<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // แสดง form ใส่ OTP
    public function showVerifyForm(Request $request)
    {
        return view('auth.verify-code', ['email' => session('email')]);
    }

    // ตรวจ OTP
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|digits:6',
        ]);

        $record = DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->where('token', $request->code)
                    ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'รหัสไม่ถูกต้อง']);
        }

        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            return back()->withErrors(['code' => 'รหัสหมดอายุแล้ว']);
        }

        // ไป reset password form
        return redirect()->route('password.reset.form')->with([
            'email' => $request->email,
            'code' => $request->code
        ]);
    }

    // แสดง form เปลี่ยนรหัสผ่าน
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', [
            'email' => session('email'),
            'code' => session('code')
        ]);
    }

    // อัปเดตรหัสผ่าน
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|digits:6',
            'password' => 'required|confirmed|min:8',
        ]);

        $record = DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->where('token', $request->code)
                    ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'รหัสไม่ถูกต้อง']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'เปลี่ยนรหัสผ่านสำเร็จแล้ว');
    }
}
