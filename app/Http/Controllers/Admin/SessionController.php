<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Trainer;
use App\Models\TrainingSession;
use Illuminate\Http\Request;


class SessionController extends Controller
{
    /**
     * Display a listing of the sessions for a program.
     */
    public function index(Program $program)
    {
        // ถ้าไม่ต้องแสดง session แค่ redirect
        return redirect()->route('admin.programs.index');
    }

    /**
     * Show the form for creating a new session for a program.
     */
    public function create(Program $program)
    {
        $trainers = Trainer::orderBy('name')->get();
        $levels = TrainingSession::getLevels();

        // คำนวณ session_number อัตโนมัติ
        $lastSession = $program->sessions()->max('session_number');
        $nextSessionNumber = $lastSession ? $lastSession + 1 : 1;

        return view('admin.sessions.create', compact('program', 'trainers', 'levels', 'nextSessionNumber'));
    }

    /**
     * Store a newly created session in storage.
     */
    public function store(Request $request, Program $program)
    {
        $validated = $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'session_number' => 'required|integer',
            'location' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:40',
            'start_at' => 'required|date|after_or_equal:today', // <-- 1. วันเริ่มต้องเป็นวันนี้หรืออนาคต
            'end_at' => 'required|date|after:start_at', // <-- 2. วันจบต้องอยู่หลังวันเริ่ม
            'registration_start_at' => 'required|date|after_or_equal:today',
            'registration_end_at' => [
                'required',
                'date',
                'after_or_equal:registration_start_at', // 1. ปิดสมัครต้องไม่ก่อนวันเปิด
                'before:start_at'                       // 2. ต้องปิดรับสมัคร "ก่อน" วันอบรมเริ่ม
            ],
            'level' => 'nullable|string|in:Beginner,Intermediate,Advanced',
        ]);

        // ใช้ create ผ่าน relationship
        $program->sessions()->create($validated);

        return redirect()->route('admin.programs.index')
                         ->with('session_created', true);
    }

    /**
     * Show the form for editing the specified session.
     */
    public function edit(Program $program, TrainingSession $session)
    {
        $trainers = Trainer::orderBy('name')->get();
        $levels = TrainingSession::getLevels();

        return view('admin.sessions.edit', compact('program', 'session', 'trainers', 'levels'));
    }

    /**
     * Update the specified session in storage.
     */
    public function update(Request $request, Program $program, TrainingSession $session)
    {
        $validated = $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'session_number' => 'required|integer',
            'location' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:40',
            'start_at' => 'required|date|after_or_equal:today', // <-- 1. วันเริ่มต้องเป็นวันนี้หรืออนาคต
            'end_at' => 'required|date|after:start_at', // <-- 2. วันจบต้องอยู่หลังวันเริ่ม
            'registration_start_at' => 'required|date|after_or_equal:today',
            'registration_end_at' => [
                'required',
                'date',
                'after_or_equal:registration_start_at', // 1. ปิดสมัครต้องไม่ก่อนวันเปิด
                'before:start_at'                       // 2. ต้องปิดรับสมัคร "ก่อน" วันอบรมเริ่ม
            ],
            'level' => 'nullable|string|in:Beginner,Intermediate,Advanced',
        ]);

        $session->update($validated);

        return redirect()->route('admin.programs.index')
                         ->with('success', 'Session updated successfully.');
    }

    /**
     * Remove the specified session from storage.
     */
    public function destroy(Program $program, TrainingSession $session)
    {
        $session->delete();

        return redirect()->route('admin.programs.index')
                         ->with('success', 'Session deleted successfully.');
    }

    // ใน TrainingSession.php
public function attendanceRateFor(User $user)
{
    $attended = $this->attendances()->where('user_id', $user->id)->count();
    $total = $this->attendances()->count();
    return $total > 0 ? ($attended / $total) * 100 : 0;
}

public function hasFeedbackFrom(User $user)
{
    return $this->feedbacks()->where('user_id', $user->id)->exists();
}

}
