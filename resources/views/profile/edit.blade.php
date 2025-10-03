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
                            {{-- Placeholder for Profile Picture --}}
                            <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full mb-4 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
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

        {{-- Upcoming Sessions (เหมือนเดิม) --}}
        <div class="p-4 sm:p-8 bg-white ...">
            <h3 class="text-lg ...">Upcoming Sessions</h3>
            @forelse($upcomingSessions as $registration)
                {{-- ... แสดงข้อมูล Upcoming Session ... --}}
            @empty
                <p>You have no upcoming sessions.</p>
            @endforelse
        </div>

        {{-- Training History (ปรับปรุงใหม่) --}}
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Training History</h3>
            <div class="space-y-4">
                @forelse($trainingHistory as $registration)
                    <div class="flex justify-between items-center border-l-4 border-gray-300 pl-4 py-2">
                        <div>
                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $registration->session->program->title }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Completed on: {{ $registration->session->end_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            {{-- ตรวจสอบว่าเคยส่ง Feedback แล้วหรือยัง --}}
                            @if($registration->feedback->isEmpty())
                                <a href="{{ route('feedback.create', $registration->session) }}" class="text-sm text-indigo-600 hover:underline">
                                    Give Feedback
                                </a>
                            @else
                                <span class="text-sm text-green-600">Feedback Submitted ✔</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">You have no completed sessions yet.</p>
                @endforelse
            </div>
        </div>

        {{-- My Certificates (ปรับปรุงใหม่) --}}
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">My Certificates</h3>
            <div class="space-y-4">
                @forelse($certificates as $certificate)
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $certificate->session->program->title }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Issued on: {{ $certificate->issued_at->format('d M Y') }}</p>
                        </div>
                        {{-- ปุ่มสำหรับดาวน์โหลด Certificate --}}
                        <a href="{{ route('certificates.download', $certificate) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                            Download
                        </a>
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
