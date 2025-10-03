<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Registration;
use App\Models\Certificate;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
public function edit(Request $request): View
{
    $user = $request->user();

    // 1. ดึง ID ของ Session ทั้งหมดที่ user ลงทะเบียนไว้
    $registeredSessionIds = $user->registrations->pluck('session_id');

    // 2. ค้นหา Session จาก ID เหล่านั้น โดยแยกตามเงื่อนไข
    $allUserSessions = \App\Models\TrainingSession::with('program')
                        ->whereIn('id', $registeredSessionIds)
                        ->orderBy('start_at', 'desc')
                        ->get();

    // 3. ใช้ Collection method เพื่อกรอง
    $upcomingSessions = $allUserSessions->where('start_at', '>=', now());
    $trainingHistory = $allUserSessions->where('start_at', '<', now())
                                       ->where('status', 'completed');

    // ... โค้ดส่วนที่เหลือ (certificates, submittedFeedback) ...

    return view('profile.edit', [
        'user' => $user,
        'upcomingSessions' => $upcomingSessions,
        'trainingHistory' => $trainingHistory,
        // ...
    ]);
}
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
