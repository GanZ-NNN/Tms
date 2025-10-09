<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\User;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateAdminController extends Controller
{
    // Dashboard
    public function index(Request $request)
    {
        $query = Certificate::with(['user', 'session']);

        if ($user = $request->input('user')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$user%"));
        }

        if ($session = $request->input('session')) {
            $query->whereHas('session', fn($q) => $q->where('title', 'like', "%$session%"));
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($from = $request->input('from')) {
            $query->whereDate('issued_at', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('issued_at', '<=', $to);
        }

        $certificates = $query->latest()->paginate(10);

        $stats = [
            'total' => Certificate::count(),
            'issued' => Certificate::where('status', 'issued')->count(),
            'sent' => Certificate::where('status', 'sent')->count(),
            'missing_pdf' => Certificate::whereNull('pdf_path')->count(),
            'missing_email' => 0,
        ];

        return view('admin.certificates.index', compact('certificates', 'stats'));
    }

    // Form generate certificate
    public function create()
    {
        $users = User::all();
        $sessions = TrainingSession::all();
        return view('admin.certificates.create', compact('users', 'sessions'));
    }

    // Store and generate certificate
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_id' => 'required|exists:training_sessions,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $session = TrainingSession::findOrFail($request->session_id);

        $certificate = Certificate::create([
            'user_id' => $user->id,
            'session_id' => $session->id,
            'issued_at' => now(),
            'status' => 'issued',
        ]);

        // Generate QR code
        $verifyUrl = url("/certificate/verify/{$certificate->verification_hash}");
        $qrCode = base64_encode(QrCode::format('png')->size(150)->generate($verifyUrl));

        // Generate PDF
        $pdf = Pdf::loadView('certificates.template', [
            'certificate' => $certificate,
            'user' => $user,
            'session' => $session,
            'qrCode' => $qrCode,
        ])->setPaper('A4', 'landscape');

        $filePath = "certificates/{$certificate->cert_no}.pdf";
        Storage::put($filePath, $pdf->output());
        $certificate->update(['pdf_path' => $filePath]);

        return redirect()->route('admin.certificates.index')
                         ->with('success', 'Certificate generated successfully!');
    }

    // Show certificate
    public function show(Certificate $certificate)
    {
        return view('admin.certificates.show', compact('certificate'));
    }

    // Delete certificate
    public function destroy(Certificate $certificate)
    {
        if ($certificate->pdf_path && Storage::exists($certificate->pdf_path)) {
            Storage::delete($certificate->pdf_path);
        }
        $certificate->delete();

        return redirect()->route('admin.certificates.index')
                         ->with('success', 'Certificate deleted successfully!');
    }

     public function searchUsers(Request $request)
    {
        $q = $request->input('q');
        $users = User::query()
            ->when($q, fn($query) => $query->where('name', 'like', "%$q%"))
            ->limit(50)
            ->get(['id','name','email']);

        return response()->json($users);
    }

    public function searchSessions(Request $request)
    {
        $q = $request->input('q');
        $sessions = TrainingSession::with('program')
            ->when($q, fn($query) => $query->where('title', 'like', "%$q%"))
            ->limit(50)
            ->get();

        return response()->json($sessions->map(fn($session) => [
            'id' => $session->id,
            'text' => ($session->program->name ?? 'No Program') .
                      ' - รอบ ' . ($session->session_number ?? '-') .
                      ' (' . $session->start_at->format('Y-m-d') .
                      ' - ' . $session->end_at->format('Y-m-d') . ')'
        ]));
    }
}
