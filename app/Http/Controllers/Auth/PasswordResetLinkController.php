<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $code = rand(100000, 999999); // สร้าง OTP 6 หลัก

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $code, 'created_at' => Carbon::now()]
        );

        Mail::raw("รหัสยืนยันของคุณคือ: {$code}", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('รหัสยืนยัน OTP สำหรับเปลี่ยนรหัสผ่าน');
        });

         return view('auth.verify-code', ['email' => session('email') ?? $request->email]);

    }
}
