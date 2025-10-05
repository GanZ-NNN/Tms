@extends('layouts.admin')

@section('title', 'แก้ไขรอบอบรม')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">แก้ไขรอบอบรมสำหรับ: {{ $program->title }}</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.programs.sessions.update', [$program, $session]) }}" method="POST">
        @csrf
        @method('PUT') {{-- สำคัญมากสำหรับการ Update --}}

        {{-- Session Number --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">รอบที่</label>
            <input type="number" name="session_number" value="{{ old('session_number', $session->session_number) }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Trainer --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ผู้สอน</label>
            <select name="trainer_id" class="w-full px-4 py-2 border rounded-lg" required>
                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}" @selected(old('trainer_id', $session->trainer_id) == $trainer->id)>
                        {{ $trainer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- {{-- Level --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ระดับ</label>
            <select name="level_id" class="w-full px-4 py-2 border rounded-lg" required>
                @foreach($levels as $level)
                    <option value="{{ $level->id }}" @selected(old('level_id', $session->level_id) == $level->id)>
                        {{ $level->name }}
                    </option>
                @endforeach
            </select>
        </div> -->

        {{-- Location --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">สถานที่</label>
            <input type="text" name="location" value="{{ old('location', $session->location) }}"
                   class="w-full px-4 py-2 border rounded-lg">
        </div>

        {{-- Capacity --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Capacity (จำนวนที่นั่ง)</label>
            <input type="number" name="capacity" value="{{ old('capacity', $session->capacity) }}"
                   class="w-full px-4 py-2 border rounded-lg" required min="1">
        </div>

        {{-- Start At --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">วันเริ่ม</label>
            <input type="datetime-local" name="start_at" value="{{ old('start_at', $session->start_at->format('Y-m-d\TH:i')) }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- End At --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">วันสิ้นสุด</label>
            <input type="datetime-local" name="end_at" value="{{ old('end_at', $session->end_at->format('Y-m-d\TH:i')) }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Registration Start --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">เริ่มเปิดสมัคร</label>
            <input type="datetime-local" name="registration_start_at" value="{{ old('registration_start_at', $session->registration_start_at?->format('Y-m-d\TH:i')) }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Registration End --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ปิดสมัคร</label>
            <input type="datetime-local" name="registration_end_at" value="{{ old('registration_end_at', $session->registration_end_at?->format('Y-m-d\TH:i')) }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Level --}}
{{-- Level --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ระดับ</label>
            <select name="level" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">-- เลือกระดับ --</option>
                {{-- วนลูปจาก Array ที่ชื่อ $levels --}}
                @foreach($levels as $levelValue)
                    <option value="{{ $levelValue }}" @selected(old('level', $session->level) == $levelValue)>
                        {{ $levelValue }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex space-x-2">
            <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition-colors duration-200">
                อัปเดต
            </button>
            <a href="{{ route('admin.programs.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-colors duration-200">
                ยกเลิก
            </a>
        </div>
    </form>
</div>
@endsection
