<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Models\User;

class TrainerController extends Controller
{
    public function index() {
        $trainers = Trainer::paginate(10);
        $users = User::paginate(10);

        return view('admin.users.index', compact('trainers', 'users'));
    }

    public function create() {
        return view('admin.trainers.create');
    }

    public function store(Request $request) {
        // ✅ Validation + ตรวจสอบ email ซ้ำ
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email', // ป้องกัน duplicate
            'phone_number' => 'nullable|string|max:20',
            'expertise' => 'nullable|string|max:255',
        ]);

        Trainer::create($validated);

        return redirect()->route('admin.trainers.index')
                         ->with('success', 'Trainer created successfully.');
    }

    public function edit(Trainer $trainer) {
        return view('admin.trainers.edit', compact('trainer'));
    }

    public function update(Request $request, Trainer $trainer) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email,' . $trainer->id, // อนุญาตให้ใช้ email เดิมของตัวเอง
            'phone_number' => 'nullable|string|max:20',
            'expertise' => 'nullable|string|max:255',
        ]);

        $trainer->update($validated);

        return redirect()->route('admin.trainers.index')
                         ->with('success', 'Trainer updated successfully.');
    }

    public function destroy(Trainer $trainer) {
        $trainer->delete();

        return redirect()->route('admin.trainers.index')
                         ->with('success', 'Trainer deleted successfully.');
    }

    public function show(Trainer $trainer)
    {
        return view('admin.trainers.show', compact('trainer'));
    }
}
