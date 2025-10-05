@extends('layouts.admin')
@section('title', 'Mark Attendance')
@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold">Attendance for: {{ $session->program->title }}</h1>
    <p class="text-gray-600 mb-2">Session: {{ $session->title ?? 'Main Session' }}</p>
    <p class="text-gray-600 mb-6">Date: {{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}</p>

    <form action="{{ route('admin.attendance.store', $session) }}" method="POST">
        @csrf
        <div class="overflow-x-auto">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th rowspan="2" class="align-middle">Trainee</th>
                        @foreach($period as $date)
                            <th colspan="2">{{ $date->format('d M') }}</th>
                        @endforeach
                        <th rowspan="2">Attendance %</th>
                    </tr>
                    <tr class="text-center">
                        @foreach($period as $date)
                            <th>AM</th>
                            <th>PM</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($session->registrations as $registration)
                        @php
                            $attended = 0;
                            $totalSlots = count($period) * 2; // AM + PM ต่อวัน
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
                                    <input type="checkbox" name="attendance[{{ $registration->id }}][{{ $dateString }}][am]" value="1" @checked($att['am'])>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="attendance[{{ $registration->id }}][{{ $dateString }}][pm]" value="1" @checked($att['pm'])>
                                </td>
                            @endforeach
                            @php
                                $attendancePercent = $totalSlots > 0 ? round(($attended / $totalSlots) * 100, 2) : 0;
                            @endphp
                            <td class="text-center {{ $attendancePercent < 80 ? 'text-red-600 font-bold' : '' }}">
                                {{ $attendancePercent }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="btn btn-primary">Save Attendance</button>
        </div>
    </form>
</main>
@endsection

