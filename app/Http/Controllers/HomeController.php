<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // สร้าง Query Builder
        $query = Program::with('category');

        // ถ้ามีการกรอก keyword ให้ค้นหา
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        // ดึงข้อมูลพร้อม Pagination และเก็บ query string
        $programs = $query->latest()->paginate(10)->withQueryString();

        // Features สำหรับหน้า home
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
        $programs = Program::latest()->take(10)->get();
        return view('programs.show', compact('program'));
    }
}
