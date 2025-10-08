@extends('layouts.admin')
@section('title', 'Attendance History')
@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-2">Attendance History</h1>
    <p class="text-gray-600 mb-4">View past attendance records for completed sessions.</p>

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 mb-4">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <a href="{{ route('admin.attendance.overview') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Manage Attendance
            </a>
            <a href="{{ route('admin.attendance.history') }}" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                History
            </a>
        </nav>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg">
            <thead class="bg-gray-100">
                <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 font-semibold">Program</th>
                    <th class="px-6 py-3 font-semibold text-center">Sessions Completed</th>
                </tr>
            </thead>

            @forelse ($programs as $program)
                <tbody class="divide-y divide-gray-200 border-t" x-data="{ open: true }">
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 font-bold">
                            <button @click="open = !open" class="flex items-center space-x-2 w-full text-lg text-left">
                                <span>{{ $program->title }}</span>
                                <svg class="w-4 h-4 transition-transform flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $program->sessions->count() }}
                        </td>
                    </tr>

                    <tr class="bg-white" x-show="open" x-cloak>
                        <td colspan="2" class="p-0">
                            <div class="px-8 py-4">
                                <table class="min-w-full">
                                    {{-- Thead ของตารางย่อย --}}
                                    <thead>
                                        <tr class="text-xs text-gray-500 border-b">
                                            <th class="py-2 text-left font-semibold">Session</th>
                                            <th class="py-2 text-center font-semibold">Avg. Attendance</th>
                                            <th class="py-2 text-right font-semibold">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($program->sessions as $session)
                                            <tr class="border-b last:border-b-0">
                                                <td class="py-3">
                                                    <div class="font-medium">{{ $session->title ?? 'รอบที่ '.$session->session_number }}</div>
                                                    <div class="text-sm text-muted">
                                                        <span>Completed on: {{ $session->end_at->format('d M Y') }}</span> |
                                                        <span>{{ $session->trainer->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                {{-- *** ส่วนที่เพิ่มเข้ามา *** --}}
                                                <td class="py-3 text-center">
                                                    <span class="font-bold text-lg {{ ($session->avg_attendance ?? 0) < 80 ? 'text-danger' : 'text-success' }}">
                                                        {{ $session->avg_attendance ?? 0 }}%
                                                    </span>
                                                </td>
                                                {{-- *** สิ้นสุดส่วนที่เพิ่มเข้ามา *** --}}
                                                <td class="py-3 text-right">
                                                    <a href="{{ route('admin.attendance.show', $session) }}" class="btn btn-outline-secondary btn-sm">
                                                        View Attendance
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="py-3 text-muted">No completed sessions for this program.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            @empty
                <tbody>
                    <tr><td colspan="2" class="text-center py-8 text-gray-500">No programs with completed sessions found.</td></tr>
                </tbody>
            @endforelse
        </table>
    </div>
</main>
@endsection