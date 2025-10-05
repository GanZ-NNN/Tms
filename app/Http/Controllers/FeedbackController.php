<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\IssueCertificateJob;

class FeedbackController extends Controller
{
    // แสดงฟอร์มสร้าง Feedback
    public function create($sessionId)
    {
        $session = TrainingSession::findOrFail($sessionId);
        $topics = [
            'การพัฒนาทักษะการสื่อสาร',
            'การบริหารเวลา',
            'การทำงานเป็นทีม',
            'การแก้ปัญหาและคิดเชิงวิพากษ์',
            'การใช้เทคโนโลยีในการทำงาน'
        ];

        return view('feedback.create', compact('session', 'topics'));
    }

    // บันทึก Feedback
   public function store(Request $request, $sessionId)
{
    $session = TrainingSession::findOrFail($sessionId); // สร้าง object session

    $request->validate([
        'sex' => 'nullable|string',
        'sex_other' => 'nullable|string',
        'age' => 'nullable|string',
        'speakers' => 'nullable|array',
        'speakers.*' => 'integer|min:1|max:5',
        'content' => 'nullable|array',
        'content.*' => 'integer|min:1|max:5',
        'staff' => 'nullable|array',
        'staff.*' => 'integer|min:1|max:5',
        'overall' => 'nullable|integer|min:1|max:5',
        'pre_knowledge' => 'nullable|integer|min:1|max:5',
        'post_knowledge' => 'nullable|integer|min:1|max:5',
        'comment' => 'nullable|string',
        'future_topics' => 'nullable|array',
        'future_topics_other' => 'nullable|string',
        'suggestions' => 'nullable|string',
    ]);

    // รวมค่า future_topics + ช่อง Other
    $futureTopics = $request->input('future_topics', []);
    if ($request->filled('future_topics_other')) {
        $futureTopics[] = $request->input('future_topics_other');
    }

    // บันทึก feedback
    Feedback::updateOrCreate(
        [
            'session_id' => $session->id,
            'user_id' => auth()->id(),
        ],
        [
            'sex' => $request->sex === 'other' ? $request->sex_other : $request->sex,
            'age' => $request->age,
            'speakers' => $request->speakers ?: null,
            'content' => $request->content ?: null,
            'staff' => $request->staff ?: null,
            'overall' => $request->overall,
            'pre_knowledge' => $request->pre_knowledge,
            'post_knowledge' => $request->post_knowledge,
            'future_topics' => !empty($futureTopics) ? $futureTopics : null,
            'comment' => $request->suggestions,
            'submitted_at' => now(),
        ]
    );

    // ใช้ $session object ที่ fetch ข้างบน
    IssueCertificateJob::dispatch(auth()->user(), $session);

    return redirect()->back()->with('success', 'Feedback submitted successfully!');
}


    // รายการ Feedback ทั้งหมด (สำหรับ admin)
    public function index()
    {
        $feedbacks = Feedback::with(['user', 'session'])->latest()->paginate(20);
        return view('feedback.index', compact('feedbacks'));
    }

    // แสดงรายละเอียด Feedback
    public function show(Feedback $feedback)
    {
        return view('feedback.show', compact('feedback'));
    }

    // ลบ Feedback
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->back()->with('success', 'Feedback deleted!');
    }


}
