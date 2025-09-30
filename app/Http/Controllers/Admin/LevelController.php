<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::orderBy('created_at','desc')->paginate(10);
        return redirect()->route('admin.categories.index');
    }

    public function create()
    {
        return view('admin.levels.create');
    }

    public function store(Request $request)
{
    // Validate
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // สร้าง Level
    Level::create([
        'name' => $request->name,
    ]);

    // Redirect กลับไปหน้า Categories พร้อมข้อความสำเร็จ
    return redirect()->route('admin.categories.index')
                     ->with('success', 'เพิ่ม Level สำเร็จแล้ว!');
}

    public function edit(Level $level)
    {
        
        return view('admin.levels.edit', compact('level'));
    }

    public function update(Request $request, Level $level)
{
    $request->validate(['name' => 'required|string|max:255']);
    $level->update($request->all());

    return redirect()->route('admin.categories.index')
                     ->with('success', 'Level ถูกแก้ไขเรียบร้อย');
}

public function destroy(Level $level)
{
    $level->delete();

    return redirect()->route('admin.categories.index')
                     ->with('success', 'Level ถูกลบเรียบร้อย');
}

}
