@extends('layouts.admin')
@section('title', 'Mark Attendance')
@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="text-2xl font-bold">Attendance for: {{ $session->program->title }}</h1>
            <p class="text-gray-600">Session: {{ $session->title ?? 'รอบที่ ' . $session->session_number }} | Date: {{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}</p>
        </div>
        @if($session->status === 'completed')
            <span class="badge bg-success fs-5">Completed</span>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.attendance.store', $session) }}" method="POST">
        @csrf
        <div class="overflow-x-auto">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr class="text-center">
                        <th rowspan="2" class="align-middle">Trainee</th>
                        @foreach($period as $date)
                            <th colspan="2">{{ $date->format('d M') }}</th>
                        @endforeach
                        <th rowspan="2" class="align-middle">Attendance %</th>
                    </tr>
                    <tr class="text-center">
                        @foreach($period as $date)
                            <th>AM</th>
                            <th>PM</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($session->registrations as $registration)
                        @php
                            $attended = 0;
                            $totalSlots = count($period) * 2;
                        @endphp
                        <tr>
                            <td>{{ $registration->user->name }}</td>
                            @foreach($period as $date)
                                @php
                                    $dateString = $date->format('Y-m-d');
                                    $att = $attendancesLookup[$registration->id][$dateString] ?? ['am' => false, 'pm' => false];
                                    $attended += ($att['am'] ? 1 : 0) + ($att['pm'] ? 1 : 0);
                                @endphp
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input" name="attendance[{{ $registration->id }}][{{ $dateString }}][am]" value="1" 
                                           @checked($att['am']) 
                                           @disabled($session->status === 'completed')> {{-- <-- 1. เพิ่ม disabled --}}
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input" name="attendance[{{ $registration->id }}][{{ $dateString }}][pm]" value="1" 
                                           @checked($att['pm']) 
                                           @disabled($session->status === 'completed')> {{-- <-- 2. เพิ่ม disabled --}}
                                </td>
                            @endforeach
                            @php
                                $attendancePercent = $totalSlots > 0 ? round(($attended / $totalSlots) * 100) : 0;
                            @endphp
                            <td class="text-center font-weight-bold {{ $attendancePercent < 80 ? 'text-danger' : 'text-success' }}">
                                {{ $attendancePercent }}%
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ (count($period) * 2) + 2 }}" class="text-center text-muted py-4">No registered users for this session.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- *** ส่วนที่แก้ไขปุ่ม *** --}}
        <div class="d-flex justify-content-end align-items-center mt-4">
            @if ($session->status === 'completed')
                {{-- ถ้า Complete แล้ว: แสดงแค่ปุ่ม Back --}}
                <a href="{{ route('admin.attendance.overview') }}" class="btn btn-secondary">
                    &larr; Back to Overview
                </a>
            @else
                {{-- ถ้ายังไม่ Complete: แสดงทั้งปุ่ม Back และ Save --}}
                 <a href="{{ route('admin.attendance.overview') }}" class="btn btn-link text-secondary me-3">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">Save Attendance</button>
            @endif
        </div>
        {{-- *** สิ้นสุดส่วนที่แก้ไข *** --}}
    </form>
</main>
@endsection