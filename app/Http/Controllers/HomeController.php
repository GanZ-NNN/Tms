<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Category;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
public function index(Request $request)
{
    $query = Program::query()->with('category', 'sessions.trainer', 'sessions.registrations');

    // กรองตาม keyword
    if ($request->filled('keyword')) {
        $query->where('title', 'like', '%' . $request->keyword . '%');
    }

    // กรองตาม group
    if ($request->filled('group')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('group', $request->group);
        });
    }

    // กรองตาม category
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    $programs = $query->latest()->get();

    $groups = Category::select('group')->distinct()->get();
    $categories = Category::all();

    return view('home', compact('programs', 'groups', 'categories'));
}

    /**
     * เมธอดนี้ไม่ได้ถูกเรียกใช้ใน Route ปัจจุบัน อาจจะลบทิ้งได้
     */
    public function show(Program $program)
    {
        // Logic นี้ควรจะอยู่ใน ProgramsController@show
        return view('programs.show', compact('program'));
    }

    /**
     * เมธอดนี้ไม่ได้ถูกเรียกใช้ใน Route ปัจจุบัน อาจจะลบทิ้งได้
     */
    public function showCourses()
    {
        // Logic นี้ควรจะอยู่ใน ProgramsController@index
        return view('programs.index');
    }
}
