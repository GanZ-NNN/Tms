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
        // เริ่มสร้าง Query สำหรับ Program
        $query = Program::query();

        // **สำคัญ:** Eager Load ข้อมูลที่จำเป็นทั้งหมดสำหรับ Card
        $query->with([
            'category', 
            'sessions' => function ($sessionQuery) {
                // โหลด Session ทั้งหมดที่ยังไม่จบ เพื่อให้ Logic ใน Blade ตัดสินใจได้
                $sessionQuery->where('status', '!=', 'completed')
                             ->orderBy('start_at', 'asc');
            },
            'sessions.trainer', 
            'sessions.level',
            'sessions.registrations' // <-- สำคัญมาก สำหรับนับจำนวนคน
        ]);

        // Logic การค้นหาจาก Hero Banner
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        
        // ดึงข้อมูล Program ทั้งหมดที่ตรงเงื่อนไข
        $programs = $query->latest()->get();
        
        return view('home', compact('programs'));
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