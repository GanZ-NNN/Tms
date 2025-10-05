<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is.admin']);
    }

    public function index(Request $request)
    {
        $query = Feedback::with(['user','trainingSession']);

        if ($request->filled('session')) {
            $query->where('session_id', $request->session);
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(20);

        // averages
        $averages = Feedback::selectRaw('AVG(speakers) as speakers, AVG(content) as content, AVG(staff) as staff, AVG(overall) as overall')
            ->when($request->filled('session'), fn($q) => $q->where('session_id', $request->session))
            ->first();

        // basic keyword extraction from comments
        $allComments = strtolower(implode(' ', Feedback::when($request->filled('session'), fn($q) => $q->where('session_id', $request->session))->pluck('comment')->toArray()));
        $words = str_word_count(preg_replace('/[^a-z0-9\s]+/i',' ', $allComments), 1);
        $wordFrequency = array_count_values($words);
        arsort($wordFrequency);
        $topWords = array_slice($wordFrequency, 0, 20);

        return view('admin.feedbacks.index', compact('feedbacks','averages','topWords'));
    }

    public function report($sessionId)
    {
        $feedbacks = Feedback::where('session_id', $sessionId)->get();

        $averages = [
            'speakers' => round($feedbacks->avg('speakers'),2),
            'content' => round($feedbacks->avg('content'),2),
            'staff' => round($feedbacks->avg('staff'),2),
            'overall' => round($feedbacks->avg('overall'),2),
        ];

        $allComments = strtolower(implode(' ', $feedbacks->pluck('comment')->toArray()));
        $words = str_word_count(preg_replace('/[^a-z0-9\s]+/i',' ', $allComments), 1);
        $wordFrequency = array_count_values($words);
        arsort($wordFrequency);
        $topWords = array_slice($wordFrequency, 0, 20);

        return response()->json([
            'averages' => $averages,
            'topWords' => $topWords,
            'count' => $feedbacks->count(),
        ]);
    }
}
