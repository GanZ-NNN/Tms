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

        // 1. ดึงข้อมูลที่จำเป็นทั้งหมดด้วย Eager Loading
        $allRegistrations = $user->registrations()
                                 ->with(['session.program', 'session.level', 'session.trainer'])
                                 ->get();

        $certificates = $user->certificates()
                             ->with('session.program')
                             ->latest('issued_at')
                             ->get();
        
        $submittedFeedbackSessionIds = \App\Models\Feedback::where('user_id', $user->id)
                                          ->pluck('session_id')
                                          ->toArray();

        // 2. กรองข้อมูลด้วย Collection Methods
        $upcomingSessions = $allRegistrations->filter(function ($registration) {
            return $registration->session && $registration->session->start_at->isFuture() && $registration->session->status !== 'completed';
        });

        $trainingHistory = $allRegistrations->filter(function ($registration) {
            return $registration->session && $registration->session->status === 'completed';
        });

        // 3. ส่งข้อมูลทั้งหมดไปที่ View
        return view('profile.edit', [
            'user' => $user,
            'upcomingSessions' => $upcomingSessions,
            'trainingHistory' => $trainingHistory,
            'certificates' => $certificates,
            'submittedFeedbackSessionIds' => $submittedFeedbackSessionIds,
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
