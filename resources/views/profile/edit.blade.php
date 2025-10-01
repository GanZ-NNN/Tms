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

                    {{-- Upcoming Sessions --}}
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Upcoming Sessions</h3>
                        <div class="space-y-4">
                            @forelse($upcomingSessions as $registration)
                                <div class="border-l-4 border-indigo-500 pl-4">
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $registration->session->program->title }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Date: {{ $registration->session->start_at->format('d M Y, H:i') }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">You have no upcoming registered sessions.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Training History --}}
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Training History</h3>
                        <div class="space-y-4">
                            @forelse($trainingHistory as $registration)
                                 <div class="border-l-4 border-gray-300 dark:border-gray-600 pl-4">
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $registration->session->program->title }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Completed on: {{ $registration->session->end_at->format('d M Y') }}</p>
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
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $certificate->session->program->title }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Issued on: {{ $certificate->issued_at->format('d M Y') }}</p>
                                    </div>
                                    <a href="{{-- route('certificates.download', $certificate) --}}" class="text-indigo-600 hover:underline">Download</a>
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
