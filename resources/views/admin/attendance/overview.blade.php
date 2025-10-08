@extends('layouts.admin')

@section('title', 'Attendance Management')

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-6">Attendance Management</h1>
    <p class="text-gray-600 mb-4">Select a session from the list below to mark attendance.</p>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg">
            {{-- Thead ของตารางหลัก (อาจจะไม่ต้องมีก็ได้ ถ้าต้องการให้คลีน) --}}
            <thead class="bg-gray-100">
                <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 font-semibold">Program</th>
                    <th class="px-6 py-3 font-semibold">Category</th>
                </tr>
            </thead>

            {{-- Loop แสดง Program และ Session --}}
            @forelse ($programs as $program)
                <tbody class="divide-y divide-gray-200 border-t" x-data="{ open: true }"> {{-- ตั้งให้เปิดไว้เลย --}}
                    {{-- แถว Program --}}
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 font-bold" colspan="2">
                            <button @click="open = !open" class="flex items-center space-x-2 w-full text-lg">
                                <span>{{ $program->title }}</span>
                                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" ...>...</svg>
                            </button>
                        </td>
                    </tr>

                    {{-- แถวตารางย่อย --}}
                    <tr class="bg-white" x-show="open" x-cloak>
                        <td colspan="2" class="p-0">
                            <div class="px-8 py-4">
                                <table class="min-w-full">
                                    <tbody>
                                        @forelse($program->sessions as $session)
                                            <tr class="border-b last:border-b-0">
                                                <td class="py-3">
                                                    <div class="font-medium">{{ $session->title ?? 'รอบที่ '.$session->session_number }}</div>
                                                    <div class="text-sm text-muted">
                                                        <span>{{ $session->start_at->format('d M Y') }}</span> |
                                                        <span>{{ $session->trainer->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-right">
                                                    @if ($session->status === 'completed')
                                                        {{-- ถ้า Complete แล้ว: แสดง Badge และปุ่ม "View" --}}
                                                        <a href="{{ route('admin.attendance.show', $session) }}" class="btn btn-outline-secondary btn-sm">
                                                            View Attendance
                                                        </a>
                                                        <span class="badge bg-success ms-1">Completed</span>
                                                    @else
                                                        {{-- ถ้ายังไม่ Complete: แสดงปุ่ม "Mark" และ "Complete" --}}
                                                        <a href="{{ route('admin.attendance.show', $session) }}" class="btn btn-info btn-sm">
                                                            Mark Attendance
                                                        </a>
                                                        <form action="{{ route('admin.sessions.complete', $session) }}" method="POST" class="d-inline ml-1" onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            <button type-="submit" class="btn btn-success btn-sm">Complete</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td class="py-3 text-muted">No sessions for this program.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </tbody>
            @empty
                <tbody>
                    <tr><td colspan="2" class="text-center py-8">No programs with active sessions found.</td></tr>
                </tbody>
            @endforelse
        </table>
    </div>
</main>
@endsection
