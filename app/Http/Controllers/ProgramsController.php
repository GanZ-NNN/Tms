<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class ProgramsController extends Controller
{
    // แสดงรายการโปรแกรมทั้งหมด
public function index()
    {

    $programs = Program::with('category')->latest()->get(); // ดึงทั้งหมด
    return view('programs.index', compact('programs'));

    }

    // แสดงรายละเอียดโปรแกรม
public function show(Program $program)
    {
        $program->load('sessions.trainer', 'sessions.level');
        return view('programs.show', compact('program'));
    }

    // ลงทะเบียนโปรแกรม (ต้อง login ก่อน)
    public function register($id)
    {
        $program = Program::findOrFail($id);

        // ตัวอย่างการบันทึกลงทะเบียน
        // สมมติว่ามี table registrations
        // Registration::create([
        //     'user_id' => Auth::id(),
        //     'program_id' => $program->id,
        // ]);

        return redirect()->route('programs.show', $program->id)
                         ->with('success', 'ลงทะเบียนสำเร็จแล้ว!');
    }
}
