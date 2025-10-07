<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Category;
use Carbon\Carbon;

class HomeController extends Controller
{
    // HomeController.php
public function index(Request $request)
{
    $query = Program::with('category');


    if ($request->filled('keyword')) {
        $query->where('title', 'like', '%' . $request->keyword . '%');
    }

    // ดึงทั้งหมด แทน paginate
    $programs = $query->latest()->get();


    return view('home', compact('programs'));
}


    public function show(Program $program)
    {

        $programs = Program::latest()->take(100)->get();
        return view('programs.show', compact('program'));
    }

    public function showCourses()
    {
        $programs = Program::orderBy('created_at', 'desc')->get();
        $categories = Category::all();

        // เรียก view programs/index.blade.php แทน
        return view('programs.index', compact('programs', 'categories'));
    }


}
