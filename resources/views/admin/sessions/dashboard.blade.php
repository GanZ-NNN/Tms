<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Session Management') }}
            </h2>
            {{-- ปุ่มนี้คือจุดเริ่มต้นของ Flow การสร้างทั้งหมด --}}
            <a href="{{ route('admin.programs.create-flow') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                + Create New Course & Session
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- (Optional) ฟอร์ม Filter ที่นี่ --}}
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Session / Program</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trainer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Schedule</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Capacity</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y dark:divide-gray-700">
                                @forelse ($sessions as $session)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium">{{ $session->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $session->program->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm">{{ $session->trainer->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $session->start_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $session->registrations_count }} / {{ $session->capacity }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <a href="{{ route('admin.attendance.show', $session) }}" class="text-blue-600 hover:underline">Attendance</a>
                                            @if ($session->status !== 'completed')
                                                <form action="{{ route('admin.sessions.complete', $session) }}" method="POST" class="inline-block ml-2">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:underline">Complete</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.programs.sessions.edit', [$session->program, $session]) }}" class="text-indigo-600 hover:underline ml-2">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No sessions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>