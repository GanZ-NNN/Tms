<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(TrainingSession $session)
    {
        // prevent duplicate - if exists, redirect to thankyou or show message
        $exists = Feedback::where('session_id', $session->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            return redirect()->route('feedback.thankyou');
        }
        // example topics - in real app this may come from DB
        $topics = [
            'Advanced PHP', 'Laravel Internals', 'Testing', 'DevOps', 'Architecture'
        ];

        return view('feedback.create', compact('session', 'topics'));
    }

    public function store(Request $request, TrainingSession $session)
    {
        $request->validate([
            'speakers' => 'nullable|integer|min:1|max:5',
            'content' => 'nullable|integer|min:1|max:5',
            'staff' => 'nullable|integer|min:1|max:5',
            'overall' => 'nullable|integer|min:1|max:5',
            'pre_knowledge' => 'nullable|integer|min:1|max:5',
            'post_knowledge' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'future_topics' => 'nullable|array',
            'future_topics.*' => 'string'
        ]);

        // Prevent duplicate submission
        $feedback = Feedback::firstOrCreate(
            ['session_id' => $session->id, 'user_id' => Auth::id()],
            array_merge($request->only(['speakers','content','staff','overall','pre_knowledge','post_knowledge','comment']), [
                'future_topics' => $request->input('future_topics', [])
            ])
        );

        return redirect()->route('feedback.thankyou');
    }

    public function thankyou()
    {
        return view('feedback.thankyou');
    }
}

