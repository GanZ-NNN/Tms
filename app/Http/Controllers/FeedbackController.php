<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\IssueCertificateJob;

class FeedbackController extends Controller
{
    /**
     * แสดงฟอร์มกรอก Feedback
     */
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

        $newsChannels = ['Facebook', 'Line Official', 'Email', 'Website', 'อื่นๆ'];
        $activityFormats = ['อบรมในห้องเรียน', 'อบรมออนไลน์', 'Workshop', 'อื่นๆ'];

        return view('feedback.create', compact('session', 'topics', 'newsChannels', 'activityFormats'));
    }

    /**
     * บันทึก Feedback
     */
    public function store(Request $request, $sessionId)
    {
        $session = TrainingSession::findOrFail($sessionId);

        $request->validate([
            'sex' => 'nullable|string',
            'sex_other' => 'nullable|string',
            'age' => 'nullable|string',

            'speakers' => 'nullable|array',
            'content' => 'nullable|array',
            'staff' => 'nullable|array',
            'faculty_related' => 'nullable|array',

            'overall' => 'nullable|integer|min:1|max:5',
            'pre_knowledge' => 'nullable|integer|min:1|max:5',
            'post_knowledge' => 'nullable|integer|min:1|max:5',

            'want_news' => 'nullable|string',
            'news_channels' => 'nullable|array',
            'news_channels_other' => 'nullable|string',

            'future_topics' => 'nullable|array',
            'future_topics_other' => 'nullable|string',

            'participated_before' => 'nullable|string',
            'activity_format' => 'nullable|string',
            'activity_format_other' => 'nullable|string',

            'instructor_info_influence' => 'nullable|string',
            'outside_hours_influence' => 'nullable|string',

            'comment' => 'nullable|string',
        ]);

        // 🧩 รวมค่าที่มีช่อง "อื่นๆ"
        $sex = $request->sex === 'อื่นๆ' ? $request->sex_other : $request->sex;

        $futureTopics = $request->input('future_topics', []);
        if ($request->filled('future_topics_other')) {
            $futureTopics[] = $request->input('future_topics_other');
        }

        $newsChannels = $request->input('news_channels', []);
        if ($request->filled('news_channels_other')) {
            $newsChannels[] = $request->input('news_channels_other');
        }

        $activityFormat = $request->activity_format === 'อื่นๆ'
            ? $request->activity_format_other
            : $request->activity_format;

        // 🧾 บันทึกหรืออัปเดต feedback
        Feedback::updateOrCreate(
            [
                'session_id' => $session->id,
                'user_id' => Auth::id(),
            ],
            [
                'sex' => $sex,
                'sex_other' => $request->sex_other,
                'age' => $request->age,

                'speakers' => $request->speakers ?: null,
                'content' => $request->content ?: null,
                'staff' => $request->staff ?: null,
                'faculty_related' => $request->faculty_related ?: null,

                'overall' => $request->overall,
                'pre_knowledge' => $request->pre_knowledge,
                'post_knowledge' => $request->post_knowledge,

                'want_news' => $request->want_news,
                'news_channels' => !empty($newsChannels) ? $newsChannels : null,
                'news_channels_other' => $request->news_channels_other,

                'future_topics' => !empty($futureTopics) ? $futureTopics : null,
                'future_topics_other' => $request->future_topics_other,

                'participated_before' => $request->participated_before,
                'activity_format' => $activityFormat,
                'activity_format_other' => $request->activity_format_other,

                'instructor_info_influence' => $request->instructor_info_influence,
                'outside_hours_influence' => $request->outside_hours_influence,

                'comment' => $request->comment,
                'submitted_at' => now(),
            ]
        );

        // 🎓 ออกใบ Certificate หลังส่งแบบประเมิน
        IssueCertificateJob::dispatch(Auth::user(), $session);

        // Redirect กลับไปหน้า "ประวัติการอบรม"
        return redirect()->route('profile.courses.history')->with('success', 'ส่งแบบประเมินสำเร็จ ขอบคุณสำหรับความคิดเห็นของคุณ!');
    }

    /**
     * รายการ Feedback (สำหรับผู้ดูแล)
     */
    public function index()
    {
        $feedbacks = Feedback::with(['user', 'session'])
            ->latest()
            ->paginate(20);

        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * รายละเอียด Feedback
     */
    public function show(Feedback $feedback)
    {
        return view('feedback.show', compact('feedback'));
    }

    /**
     * ลบ Feedback
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->back()->with('success', 'Feedback deleted successfully!');
    }
}
