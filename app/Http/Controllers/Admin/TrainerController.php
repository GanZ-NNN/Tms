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
    $users = User::paginate(10); // เพิ่มบรรทัดนี้

    return view('admin.users.index', compact('trainers', 'users'));
    }

    public function create() {
        return view('admin.trainers.create');
    }

    public function store(Request $request) {
        Trainer::create($request->all());
        return redirect()->route('admin.trainers.index');
    }

    public function edit(Trainer $trainer) {
        return view('admin.trainers.edit', compact('trainer'));
    }

    public function update(Request $request, Trainer $trainer) {
        $trainer->update($request->all());
        return redirect()->route('admin.trainers.index');
    }

    public function destroy(Trainer $trainer) {
        $trainer->delete();
        return redirect()->route('admin.trainers.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

}
