<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession;
// use App\Jobs\IssueCertificatesJob; // สำหรับอนาคต
use Illuminate\Http\Request;

class SessionCompletionController extends Controller
{
    /**
     * Mark the specified session as complete.
     */
    public function complete(TrainingSession $session)
    {
        // 1. ตรวจสอบว่า Session ยังไม่ถูก complete มาก่อน
        if ($session->status === 'completed') {
            return back()->with('info', "Session '{$session->title}' is already marked as complete.");
        }

        // 2. เปลี่ยนสถานะ Session
        $session->update(['status' => 'completed']);

        // 3. (อนาคต) Trigger Job สำหรับออก Certificate
        // IssueCertificatesJob::dispatch($session);

        // 4. Redirect กลับไปหน้าเดิม พร้อมข้อความแจ้งเตือน
        return back()->with('success', "Session '{$session->title}' has been marked as complete.");
    }
}