<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program; // อย่าลืม import model
use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Models\Level;
use App\Models\TrainingSession;

class SessionController extends Controller
{
    /**
     * Display a listing of the sessions for a program.
     */
    public function index(Program $program)
    {
        return redirect()->route('admin.programs.index');
    }

    /**
     * Show the form for creating a new session for a program.
     */
    public function create(Program $program)
    {
        $trainers = Trainer::orderBy('name')->get();
        return view('admin.sessions.create', compact('program', 'trainers'));
    }

    /**
     * Store a newly created session.
     */
    public function store(Request $request, Program $program)
    {
        $validated = $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'session_number' => 'required|integer',
            'location' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:40',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'registration_start_at' => 'required|date',
            'registration_end_at' => 'required|date|after:registration_start_at',
        ]);

        $program->sessions()->create($validated);

        return redirect()->route('admin.programs.sessions.index', $program)
                         ->with('success', 'Session created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program, TrainingSession $session)
    {
        // ดึงข้อมูลที่จำเป็นสำหรับ Dropdown ในฟอร์มแก้ไข
        $trainers = Trainer::orderBy('name')->get();
        $levels = Level::orderBy('name')->get();

        // ส่งข้อมูลทั้งหมดที่ View ต้องการไป
        return view('admin.sessions.edit', compact('program', 'session', 'trainers', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
