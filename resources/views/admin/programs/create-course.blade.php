<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Course and First Session') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.programs.quick-store') }}" method="POST">
                        @csrf
                        {{-- Course Details --}}
                        <h2 class="text-xl font-semibold mb-4 ...">Course Information (Program)</h2>
                        {{-- ... โค้ดฟอร์มสำหรับ Program (Title, Description, Category + Modal) ... --}}
                        
                        {{-- First Session Details --}}
                        <h2 class="text-xl font-semibold mt-8 mb-4 ...">First Session Information</h2>
                        {{-- ... โค้ดฟอร์มสำหรับ Session (Start, End, Trainer, Capacity, Location) ... --}}

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('admin.dashboard') }}" class="text-sm ...">Cancel</a>
                            <x-primary-button class="ml-4">Create Course & Session</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal และ Script สำหรับสร้าง Category --}}
    {{-- ... โค้ด Modal และ Script ที่เราทำเสร็จแล้ว ... --}}
</x-app-layout>