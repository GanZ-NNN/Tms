<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;

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

    $features = [
        [
            'icon' => '<svg>...</svg>',
            'title' => 'Explore new skills',
            'description' => 'Access 10,000+ courses in AI, business, technology, and more.',
        ],
        [
            'icon' => '<svg>...</svg>',
            'title' => 'Earn valuable credentials',
            'description' => 'Get certificates for every course you finish and boost your chances of getting hired.',
        ],
        [
            'icon' => '<svg>...</svg>',
            'title' => 'Learn from the best',
            'description' => 'Take your skills to the next level with expert-led courses and AI guidance.',
        ],
    ];

    return view('home', compact('programs', 'features'));
}


    public function show(Program $program)
    {

        $programs = Program::latest()->take(100)->get();
        return view('programs.show', compact('program'));
    }

    public function showcoures()
    {
        $programs = Program::with('category')->latest()->get();
        return view('admin.showcoures', compact('programs'));
    }
}
