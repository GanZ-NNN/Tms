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
        $levels = TrainingSession::getLevels();


        return view('admin.sessions.create', compact('program', 'trainers', 'levels'));
    }

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
            'level_id' => 'nullable|exists:levels,id',
        ]);

        $program->sessions()->create($validated);

        return redirect()->route('admin.programs.index')
                         ->with('success', 'Session created successfully.');
    }

    public function edit(Program $program, TrainingSession $session)
    {
        $trainers = Trainer::orderBy('name')->get();


        return view('admin.sessions.edit', compact('program', 'session', 'trainers', 'levels'));
    }

    public function update(Request $request, Program $program, TrainingSession $session)
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
            'level_id' => 'nullable|exists:levels,id',
        ]);

        $session->update($validated);

        return redirect()->route('admin.programs.index')
                         ->with('success', 'Session updated successfully.');
    }

    public function destroy(Program $program, TrainingSession $session)
    {
        $session->delete();

        return redirect()->route('admin.programs.index')
                         ->with('success', 'Session deleted successfully.');
    }
}
