<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- ========== Left Column: Personal Details ========== -->
                <div class="md:col-span-1 space-y-6">
                    {{-- Personal Info Card --}}
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="flex flex-col items-center text-center">
                            {{-- ... โค้ดแสดงรูปโปรไฟล์, ชื่อ, อีเมล ... --}}
                        </div>
                    </div>
                    {{-- Edit Profile Information Form --}}
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- ========== Right Column: Training & Certificates ========== -->
                <div class="md:col-span-2 space-y-6">

                    {{-- Upcoming Sessions (ฉบับแก้ไข) --}}
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Upcoming Sessions</h3>
                        <div class="space-y-4">
                            @forelse($upcomingSessions as $registration)
                                <div class="border-l-4 border-indigo-500 pl-4">
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $registration->session->program->title }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $registration->session->title ?? 'รอบที่ ' . $registration->session->session_number }}
                                    </p>
                                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        <span>Date: {{ $registration->session->start_at->format('d M Y, H:i') }}</span> |
                                        <span>Location: {{ $registration->session->location ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">You have no upcoming registered sessions.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Training History (ฉบับแก้ไข) --}}
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Training History</h3>
                        <div class="space-y-4">
                            @forelse($trainingHistory as $registration)
                                <div class="flex justify-between items-center border-l-4 border-gray-300 dark:border-gray-600 pl-4 py-2">
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $registration->session->program->title }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $registration->session->title ?? 'รอบที่ ' . $registration->session->session_number }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Completed on: {{ $registration->session->end_at->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        @if(in_array($registration->session_id, $submittedFeedbackSessionIds))
                                            <span class="text-sm text-green-600 dark:text-green-400">Feedback Submitted ✔</span>
                                        @else
                                            <a href="{{ route('feedback.create', $registration->session) }}" class="text-sm text-indigo-600 hover:underline">
                                                Give Feedback
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">You have no completed sessions yet.</p>
                            @endforelse
                        </div>
                    </div>

        {{-- My Certificates --}}
<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">My Certificates</h3>
    <div class="space-y-4">
        @forelse($certificates as $certificate)
            @php
                $session = optional($certificate->session);
                $program = optional($session->program);
            @endphp

            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $program->title ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Issued on: {{ optional($certificate->issued_at)?->format('d M Y') ?? '-' }}
                    </p>
                </div>
                {{-- ปุ่มดาวน์โหลด --}}
                @if($certificate->pdf_path && \Illuminate\Support\Facades\Storage::exists($certificate->pdf_path))
                    <a href="{{ route('certificates.download', $certificate) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        Download
                    </a>
                @else
                    <span class="px-3 py-1 bg-gray-400 text-white rounded cursor-not-allowed">Not Ready</span>
                @endif
            </div>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">You have no certificates yet.</p>
        @endforelse
    </div>
</div>


                    {{-- Update Password & Delete Account (ย้ายมาไว้ล่างสุด) --}}
                    {{-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div> --}}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
