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

    // 1. ดึงข้อมูลรอบอบรมที่กำลังจะมาถึง
    $upcomingSessions = $user->registrations()
        ->with('session.program')
        ->whereHas('session', fn($query) => $query->where('start_at', '>=', now()))
        ->latest('id')
        ->get();

    // 2. ดึงข้อมูลประวัติการอบรม (รอบที่จบไปแล้ว)
    $trainingHistory = $user->registrations()
        ->with('session.program')
        ->whereHas('session', fn($query) => $query->where('status', 'completed'))
        ->latest('id')
        ->get();

    // 3. ดึงใบรับรองทั้งหมดของผู้ใช้
    $certificates = $user->certificates()->with('session.program')->latest('issued_at')->get();

    // 4. (ใหม่) ดึง ID ของ Session ที่ User คนนี้เคยส่ง Feedback ไปแล้ว
    $submittedFeedbackSessionIds = \App\Models\Feedback::where('user_id', $user->id)
                                      ->pluck('session_id')
                                      ->toArray();

    return view('profile.edit', [
        'user' => $user,
        'upcomingSessions' => $upcomingSessions,
        'trainingHistory' => $trainingHistory,
        'certificates' => $certificates,
        'submittedFeedbackSessionIds' => $submittedFeedbackSessionIds, // <-- ส่งตัวแปรใหม่ไปที่ View
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

    public function myCertificates()
{
    $user = auth()->user();
    $certificates = $user->certificates()->with('session.program')->get();

    return view('profile.certificates', compact('certificates'));
}

}
