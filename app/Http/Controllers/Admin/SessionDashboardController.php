<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionDashboardController extends Controller
{
    public function index()
    {
        // ตัวอย่าง: ดึง session ทั้งหมดมาแสดง
        // $sessions = \App\Models\TrainingSession::all();
        // return view('admin.dashboard', compact('sessions'));

        return view('admin.dashboard'); // ถ้ายังไม่มี data
    }
}
