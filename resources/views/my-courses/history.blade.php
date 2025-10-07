<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ประวัติการอบรม') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    
                    @forelse ($trainingHistory as $registration)
                        {{-- *** ส่วนที่แก้ไข *** --}}
                        <div class="border-t first:border-t-0 pt-6 first:pt-0">
                            <div class="flex flex-col md:flex-row md:justify-between">
                                <!-- Course & Session Info -->
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200">
                                        <a href="{{ route('programs.show', $registration->session->program) }}" class="hover:underline">
                                            {{ $registration->session->program->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ $registration->session->title ?? 'รอบที่ ' . $registration->session->session_number }}
                                    </p>
                                    <div class="text-sm text-gray-500 dark:text-gray-500 mt-2">
                                        <span>Completed on: {{ $registration->session->end_at->format('d M Y') }}</span> |
                                        <span>Trainer: {{ $registration->session->trainer->name ?? 'N/A' }}</span> |
                                        <span>Level: {{ $registration->session->level ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                                    {{-- (อนาคต) ปุ่ม Give Feedback --}}
                                    {{-- <a href="#" class="text-sm text-indigo-600 hover:underline">Give Feedback</a> --}}
                                    
                                    {{-- (อนาคต) ปุ่ม Download Certificate --}}
                                    {{-- <a href="#" class="inline-block px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">Download</a> --}}
                                </div>
                            </div>
                        </div>
                        {{-- *** สิ้นสุดส่วนที่แก้ไข *** --}}
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400">ยังไม่มีประวัติการอบรม</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>