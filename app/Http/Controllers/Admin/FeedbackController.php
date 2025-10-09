<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\TrainingSession;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is.admin']);
    }

    /**
     * หน้าแสดง Feedback ทั้งหมด พร้อมค่าเฉลี่ย, Demographics และ Top Keywords
     */
    public function index(Request $request)
    {
        $query = Feedback::with(['user','trainingSession']);


        if ($request->filled('session')) {
            $query->where('session_id', $request->session);
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(10);

        $allFeedbacks = $query->get();
        $count = $allFeedbacks->count();

        // 🧮 คำนวณ averages และ detailed
        $total = [
            'speakers' => 0,
            'content' => 0,
            'staff' => 0,
            'overall' => 0,
            'pre_knowledge' => 0,
            'post_knowledge' => 0
        ];

        $detailed = [
            'speakers' => [],
            'content' => [],
            'staff' => []
        ];

        foreach ($allFeedbacks as $f) {
            $speakers = is_array($f->speakers) ? array_sum($f->speakers)/count($f->speakers) : (float)$f->speakers;
            $content  = is_array($f->content) ? array_sum($f->content)/count($f->content) : (float)$f->content;
            $staff    = is_array($f->staff) ? array_sum($f->staff)/count($f->staff) : (float)$f->staff;

            $total['speakers']     += $speakers;
            $total['content']      += $content;
            $total['staff']        += $staff;
            $total['overall']      += (float)$f->overall;
            $total['pre_knowledge'] += (float)$f->pre_knowledge;
            $total['post_knowledge'] += (float)$f->post_knowledge;

            $detailed['speakers'][] = $speakers;
            $detailed['content'][] = $content;
            $detailed['staff'][] = $staff;
        }

        $averages = [];
        foreach ($total as $key => $sum) {
            $averages[$key] = $count > 0 ? round($sum / $count, 2) : 0;
        }

        // Detailed
        $averages['speakers_detailed'] = $detailed['speakers'];
        $averages['content_detailed'] = $detailed['content'];
        $averages['staff_detailed'] = $detailed['staff'];

        // 🧾 Demographics
        $demographics = [
            'sex' => [],
            'age' => []
        ];
        foreach ($allFeedbacks as $f) {
            if ($f->sex) $demographics['sex'][$f->sex] = ($demographics['sex'][$f->sex] ?? 0) + 1;
            if ($f->age) $demographics['age'][$f->age] = ($demographics['age'][$f->age] ?? 0) + 1;
        }

        // 🔮 Future Topics Count
        $futureTopicsCount = [];
        foreach ($allFeedbacks as $f) {
            $topics = $f->future_topics ?? [];
            if (!is_array($topics)) $topics = [$topics];
            foreach ($topics as $t) {
                if ($t) $futureTopicsCount[$t] = ($futureTopicsCount[$t] ?? 0) + 1;
            }
        }

        // 📝 Top Keywords
        $allComments = strtolower(implode(' ', $allFeedbacks->pluck('comment')->toArray()));
        $words = str_word_count(preg_replace('/[^a-z0-9ก-๙\s]+/ui',' ', $allComments), 1); // รองรับภาษาไทย
        $wordFrequency = array_count_values($words);
        arsort($wordFrequency);
        $topWords = array_slice($wordFrequency, 0, 20);

        return view('admin.feedbacks.index', compact(
            'feedbacks','averages','demographics','futureTopicsCount','topWords'
        ));
    }

    /**
     * รายงาน Feedback ของ Session
     */
    public function report($sessionId)
    {
        $feedbacks = Feedback::where('session_id', $sessionId)->get();
        $count = $feedbacks->count();

        $totalScores = [
            'speakers' => 0,
            'content' => 0,
            'staff' => 0,
            'overall' => 0,
            'pre_knowledge' => 0,
            'post_knowledge' => 0
        ];

        foreach ($feedbacks as $f) {
            $speakers = is_array($f->speakers) ? array_sum($f->speakers)/count($f->speakers) : (float)$f->speakers;
            $content  = is_array($f->content) ? array_sum($f->content)/count($f->content) : (float)$f->content;
            $staff    = is_array($f->staff) ? array_sum($f->staff)/count($f->staff) : (float)$f->staff;

            $totalScores['speakers']     += $speakers;
            $totalScores['content']      += $content;
            $totalScores['staff']        += $staff;
            $totalScores['overall']      += (float)$f->overall;
            $totalScores['pre_knowledge'] += (float)$f->pre_knowledge;
            $totalScores['post_knowledge'] += (float)$f->post_knowledge;
        }

        $averageScores = [];
        foreach ($totalScores as $key => $sum) {
            $averageScores[$key] = $count > 0 ? round($sum / $count, 2) : 0;
        }

        return view('admin.feedbacks.report', [
            'feedbacks' => $feedbacks,
            'averageScores' => $averageScores,
            'count' => $count
        ]);
    }

    /**
     * Export Feedback เป็น CSV
     */
   public function export()
    {
        $feedbacks = Feedback::with(['user', 'trainingSession'])->get();

        $csvData = [];
        $csvData[] = [
            'Session', 'User', 'Speakers', 'Content', 'Staff',
            'Overall', 'Pre Knowledge', 'Post Knowledge', 'Comment', 'Submitted At'
        ];

        foreach ($feedbacks as $f) {
            $csvData[] = [
                $f->trainingSession->title ?? '-',
                $f->user->name ?? '-',
                is_array($f->speakers) ? implode(',', $f->speakers) : $f->speakers,
                is_array($f->content) ? implode(',', $f->content) : $f->content,
                is_array($f->staff) ? implode(',', $f->staff) : $f->staff,
                $f->overall,
                $f->pre_knowledge,
                $f->post_knowledge,
                $f->comment,
                $f->submitted_at,
            ];
        }

        $filename = 'feedbacks_' . now()->format('Ymd_His') . '.csv';
        $handle = fopen('php://temp', 'r+');

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $contents = stream_get_contents($handle);
        fclose($handle);

        return Response::make($contents, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}
