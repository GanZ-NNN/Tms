@extends('layouts.admin')

@section('title', 'Select Session for Attendance')

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-6">Select Session to Mark Attendance</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg">
            <thead>
                <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 font-semibold">Session / Program</th>
                    <th class="px-6 py-3 font-semibold">Date</th>
                    <th class="px-6 py-3 font-semibold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($sessions as $session)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $session->title ?? $session->program->title }}</div>
                        <small class="text-muted">{{ $session->program->title }}</small>
                    </td>
                    <td class="px-6 py-4">
                        {{ $session->start_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        {{-- ลิงก์นี้จะพาไปหน้าเช็คชื่อของ Session นั้นๆ --}}
                        <a href="{{ route('admin.attendance.show', $session) }}" class="btn btn-info btn-sm">
                            Mark Attendance
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">No recent or upcoming sessions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $sessions->links() }}</div>
</main>
@endsection