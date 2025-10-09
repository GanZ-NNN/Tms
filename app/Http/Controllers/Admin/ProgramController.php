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
        $query->with(['category', 'sessions.trainer']);

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

    $program = Program::create($data);

    if ($request->expectsJson()) {
        return response()->json([
            'message' => 'หลักสูตรถูกบันทึกเรียบร้อยแล้ว',
            'program' => $program
        ]);
    }

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
        'category_id' => 'nullable|exists:categories,id',
        'detail' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('programs', 'public');
    }

    $program->update($data);

    // ถ้า request เป็น AJAX/JSON ให้ส่ง JSON กลับ
    if ($request->expectsJson()) {
        return response()->json(['message' => 'หลักสูตรถูกบันทึกเรียบร้อยแล้ว']);
    }

    return redirect()->route('admin.programs.edit', $program)->with('success', 'Program updated successfully.');
}




    public function destroy(Program $program, Request $request)
{
    $program->delete();

    // ถ้าเป็น AJAX request
    if ($request->expectsJson() || $request->ajax()) {
        return response()->json([
            'message' => 'ลบหลักสูตรเรียบร้อยแล้ว'
        ]);
    }

    return redirect()->route('admin.programs.index')->with('success', 'ลบหลักสูตรเรียบร้อยแล้ว');
}


    public function show($id)
    {
        $program = Program::findOrFail($id);
        return view('programs.show', compact('program'));
    }
}
