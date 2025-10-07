@extends('layouts.admin')

@section('title', 'สร้างรอบอบรมใหม่')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">สร้างรอบอบรมใหม่: {{ $program->title }}</h1>

    {{-- แสดง Error --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.programs.sessions.store', $program) }}" method="POST">
        @csrf

        {{-- Session Number --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">รอบที่</label>
            <input type="number" name="session_number"
                value="{{ old('session_number', $nextSessionNumber) }}"
                class="w-full px-4 py-2 border rounded-lg" required readonly>
        </div>

        {{-- Trainer --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ผู้สอน</label>
            <select id="trainer-select" name="trainer_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">-- เลือกผู้สอน --</option>
                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}"
                        {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                        {{ $trainer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Location --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">สถานที่</label>
            <input type="text" name="location" value="{{ old('location') }}"
                   class="w-full px-4 py-2 border rounded-lg">
        </div>

        {{-- Capacity --}}
        <div class="mb-4">
            <label for="capacity" class="block mb-1 font-semibold">Capacity (จำนวนที่นั่ง):</label>
            <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 20) }}"
                   class="w-full px-4 py-2 border rounded-lg" required min="1">
        </div>

        {{-- Start At --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">วันเริ่ม</label>
            <input type="datetime-local" name="start_at" value="{{ old('start_at') }}"
            min="{{ now()->format('Y-m-d\TH:i') }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- End At --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">วันสิ้นสุด</label>
            <input type="datetime-local" name="end_at" value="{{ old('end_at') }}"
            min="{{ now()->format('Y-m-d\TH:i') }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Registration Start --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">เริ่มเปิดสมัคร</label>
            <input type="datetime-local" name="registration_start_at" value="{{ old('registration_start_at') }}"
            min="{{ now()->format('Y-m-d\TH:i') }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Registration End --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ปิดสมัคร</label>
            <input type="datetime-local" name="registration_end_at" value="{{ old('registration_end_at') }}"
            min="{{ now()->format('Y-m-d\TH:i') }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

       {{-- Level --}}
       <div class="mb-4">
            <label class="block mb-1 font-semibold">ระดับ</label>
        <select name="level" required>
            <option value="">-- เลือกระดับ --</option>
            @foreach($levels as $level)
                <option value="{{ $level }}">{{ $level }}</option>
            @endforeach
        </select>

        </div>



        {{-- Buttons --}}
        <div class="flex space-x-2">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                บันทึก
            </button>
            <a href="{{ route('admin.programs.index') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-colors duration-200">
                ยกเลิก
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    new TomSelect('#trainer-select', {
        searchField: 'text',
        create: false,
        sortField: { field: "text", direction: "asc" }
    });
});
</script>
@endpush
