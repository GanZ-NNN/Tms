<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('group', 'like', '%' . $request->search . '%');
            });
        }

        $categories = $query->latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $groups = ['A', 'B', 'C', 'D', 'E', 'F'];
        return view('admin.categories.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group' => 'required|string|in:A,B,C,D,E,F',
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create($validated);

        // ส่ง JSON ตลอด
        return response()->json([
            'success' => true,
            'message' => 'เพิ่มหมวดหมู่เรียบร้อย',
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        $groups = ['A', 'B', 'C', 'D', 'E', 'F'];
        return view('admin.categories.edit', compact('category', 'groups'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'group' => 'required|string|in:A,B,C,D,E,F',
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'อัปเดตหมวดหมู่เรียบร้อย',
            'category' => $category
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบหมวดหมู่เรียบร้อย'
        ]);
    }
}
