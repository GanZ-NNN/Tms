<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession;

class RegistrationController extends Controller
{
    public function index(TrainingSession $session)
    {
        $session->load('registrations.user'); // โหลดข้อมูลที่จำเป็น

        return view('admin.registrations.index', compact('session'));
    }
}