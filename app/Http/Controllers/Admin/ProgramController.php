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
    public function index(Request $request) // <-- เพิ่ม Request เข้ามาเพื่อรองรับ Search
    {
        // เริ่มสร้าง Query Builder สำหรับ Program
        $query = Program::query();

        // **ส่วนที่เพิ่มเข้ามา:** โหลดความสัมพันธ์ 'sessions' และ 'sessions.trainer' มาด้วย
        // เพื่อให้หน้าเว็บแสดงข้อมูล Session ซ้อนกันได้โดยไม่มีปัญหา N+1 Query
        $query->with(['category', 'sessions.trainer']);

        // (Optional) ทำให้ Search Bar ทำงานได้
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        // **ส่วนที่เปลี่ยนแปลง:** ใช้ get() แทน paginate() เพื่อดึงข้อมูลทั้งหมดมาแสดงในหน้าเดียว
        $programs = $query->latest()->get(); 

        // ดึง categories มาสำหรับ Filter (ถ้ามี)
        $categories = Category::all();

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
            'capacity' => 'required|integer|min:1',
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
            'capacity' => 'required|integer|min:1',
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
        $program = \App\Models\Program::findOrFail($id);
        return view('programs.show', compact('program'));
    }
}