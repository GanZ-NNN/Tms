<?php

// app/Http/Controllers/FeedbackController.php
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        // ดึง feedback ทั้งหมด พร้อม session ที่เกี่ยวข้อง
        $feedbacks = Feedback::with('session')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.feedback.index', compact('feedbacks'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Feedback::create([
            'session_id' => $request->session_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'บันทึกแบบประเมินสำเร็จ']);
    }

    public function report($sessionId)
    {
        $feedbacks = Feedback::where('session_id', $sessionId)->get();
        $average = round($feedbacks->avg('rating'), 2);

        // คำหลักที่พบบ่อย
        $allComments = strtolower(implode(' ', $feedbacks->pluck('comment')->toArray()));
        $words = str_word_count($allComments, 1);
        $wordFrequency = array_count_values($words);
        arsort($wordFrequency);
        $topWords = array_slice($wordFrequency, 0, 10);

        return response()->json([
            'average' => $average,
            'feedbacks' => $feedbacks,
            'keywords' => $topWords,
        ]);
    }
}

