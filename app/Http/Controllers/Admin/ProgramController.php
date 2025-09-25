<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Category;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->paginate(10); // หรือ all() แล้วแต่ต้องการ
        $categories = Category::all(); // ส่ง categories ไปด้วย

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
