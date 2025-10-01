<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Category;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource along with their sessions.
     */
    public function index(Request $request)
    {
        // เริ่มสร้าง Query Builder สำหรับ Program
        $query = Program::query();

        // โหลดความสัมพันธ์ที่จำเป็นทั้งหมด
        $query->with(['category', 'sessions.trainer', 'sessions.level']);

        // (Optional) ทำให้ Search Bar ทำงานได้
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        // ดึงข้อมูล Program ทั้งหมดมาแสดงในหน้าเดียว
        $programs = $query->latest()->get(); 

        // ดึง categories ทั้งหมดมาสำหรับ Filter Dropdown โดยเรียงตามชื่อ
        $categories = Category::orderBy('name')->get();

        // ส่งตัวแปรทั้งสองไปที่ View
        return view('admin.programs.index', compact('programs', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.programs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('program_images', 'public');
        }

        Program::create($data);

        return redirect()->route('admin.programs.index')->with('success', 'Program created successfully.');
    }

    public function edit(string $id)
    {
        $program = Program::findOrFail($id);
        $categories = Category::all(); // สำหรับ dropdown
        return view('admin.programs.edit', compact('program', 'categories'));
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('program_images', 'public');
        }

        $program->update($data);

        return redirect()->route('admin.programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program deleted successfully.');
    }

    public function show($id)
    {
        $program = Program::findOrFail($id);
        return view('programs.show', compact('program'));
    }
}
