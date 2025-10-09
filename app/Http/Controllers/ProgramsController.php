<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class ProgramsController extends Controller
{
    /**
     * Display a paginated list of all programs.
     * (สำหรับหน้า /programs)
     */
public function index(Request $request)
    {
        // เริ่มสร้าง Query สำหรับ Program
        $query = Program::query();

        // **สำคัญ:** Eager Load ข้อมูลที่จำเป็นทั้งหมดสำหรับ Card
        $query->with([
            'category', 
            'sessions' => function ($query) {
                // โหลด Session ทั้งหมดที่ยังไม่จบ เพื่อให้ Logic ใน Blade ตัดสินใจได้
                $query->where('status', '!=', 'completed')
                      ->orderBy('start_at', 'asc');
            },
            'sessions.trainer',
            'sessions.level',
            'sessions.registrations' // <-- สำคัญมาก สำหรับนับจำนวนคน
        ]);

        // Logic การค้นหา
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        
        // (Optional) คุณสามารถเพิ่ม Filter ตาม Category ได้ที่นี่
        // if ($request->filled('category')) {
        //     $query->where('category_id', $request->category);
        // }

        // ใช้ paginate เพื่อแบ่งหน้า
        $programs = $query->latest()->paginate(9);

        // (Optional) ดึง Categories ทั้งหมดมาเพื่อใช้ใน Filter Dropdown
        // $categories = \App\Models\Category::orderBy('name')->get();

        return view('programs.index', compact('programs' /*, 'categories' */));
    }

    /**
     * Display the specified program and its available sessions.
     * (สำหรับหน้า /programs/{program})
     */
    public function show(Program $program)
    {
        // **สำคัญ:** Eager Load ข้อมูล session ทั้งหมดและข้อมูลที่ซ้อนอยู่
        $program->load([
            'category',
            'sessions' => function ($query) {
                // โหลดเฉพาะ Session ที่ยังไม่จบ
                $query->where('status', '!=', 'completed')->orderBy('start_at', 'asc');
            },
            'sessions.trainer',
            'sessions.level',
            'sessions.registrations' // <-- สำคัญมาก สำหรับการเช็คสถานะปุ่ม
        ]);
        
        return view('programs.show', compact('program'));
    }
}
