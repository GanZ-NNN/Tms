<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'occupation' => ['nullable', 'string', 'max:100'],
        ]);

        // สร้างผู้ใช้
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'occupation' => $request->occupation,
        ]);

        // ส่งอีเมลต้อนรับ
        Mail::to($user->email)->send(new WelcomeMail($user));

        // Login ให้ทันที
        Auth::login($user);

        // Redirect ไปหน้า dashboard พร้อมข้อความ
        return redirect()->route('dashboard')->with('success', 'สมัครสมาชิกสำเร็จ — ยินดีต้อนรับ!');
    }
}
