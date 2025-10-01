<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\User;
use App\Models\TrainingSession;
use Illuminate\Http\Request;

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

        // เรียกใช้ CertificateController.generate
        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate generated successfully!');
    }

    public function show(Certificate $certificate)
    {
        return view('admin.certificates.show', compact('certificate'));
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return back()->with('success', 'Certificate deleted!');
    }
}
