<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display an overview of feedback for all sessions.
     */
    public function feedbackIndex()
    {
        $sessionsWithFeedback = TrainingSession::has('feedback') // เอาเฉพาะ Session ที่มี Feedback
            ->with('program')
            ->withCount('feedback') // นับจำนวน Feedback
            ->withAvg('feedback', 'rating') // หาค่าเฉลี่ย rating
            ->latest('start_at')
            ->paginate(15);

        return view('admin.reports.feedback-index', [
            'sessions' => $sessionsWithFeedback,
        ]);
    }

    /**
     * Display detailed feedback for a specific session.
     */
    public function feedbackDetails(TrainingSession $session)
    {
        // โหลดข้อมูล feedback ทั้งหมด พร้อมกับ user ที่ส่ง
        $session->load('feedback.user');

        return view('admin.reports.feedback-details', [
            'session' => $session,
        ]);
    }

    /**
     * Export feedback for a specific session to a CSV file.
     */
    public function exportFeedback(TrainingSession $session)
    {
        $session->load('feedback.user');
        $fileName = 'feedback-' . $session->program->title . '-' . $session->start_at->format('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($session) {
            $file = fopen('php://output', 'w');
            // Header Row
            fputcsv($file, ['User Name', 'Rating (1-5)', 'Comment', 'Submitted At']);

            // Data Rows
            foreach ($session->feedback as $feedback) {
                fputcsv($file, [
                    $feedback->user->name,
                    $feedback->rating,
                    $feedback->comment,
                    $feedback->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}