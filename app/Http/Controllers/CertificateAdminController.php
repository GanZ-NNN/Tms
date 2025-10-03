<?php
namespace App\Http\Controllers;

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
    public function index()
    {
        $certificates = Certificate::with(['user', 'session'])->latest()->paginate(10);
        return view('admin.certificates.index', compact('certificates'));
    }

    public function create()
    {
        $users = User::all();
        $sessions = TrainingSession::all();
        return view('admin.certificates.create', compact('users', 'sessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_id' => 'required|exists:training_sessions,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $session = TrainingSession::findOrFail($request->session_id);

        // สร้าง certificate record
        $certificate = Certificate::create([
            'user_id' => $user->id,
            'session_id' => $session->id,
            'issued_at' => now(),
        ]);

        // สร้าง PDF
        $pdf = Pdf::loadView('certificates.template', [
            'certificate' => $certificate,
            'user' => $user,
            'session' => $session,
            'qrCode' => base64_encode(
                QrCode::format('png')->size(120)->generate(
                    url("/certificate/verify/" . $certificate->verification_hash)
                )
            )
        ]);

        $filePath = "certificates/{$certificate->cert_no}.pdf";
        Storage::put($filePath, $pdf->output());
        $certificate->update(['pdf_path' => $filePath]);

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate generated successfully!');
    }

    public function show(Certificate $certificate)
    {
        return view('admin.certificates.show', compact('certificate'));
    }

    public function destroy(Certificate $certificate)
    {
        if (Storage::exists($certificate->pdf_path)) {
            Storage::delete($certificate->pdf_path);
        }
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate deleted successfully!');
    }
}
