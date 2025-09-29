@extends('layouts.admin')

@section('title', 'จัดการโปรแกรม / รอบอบรม')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">โปรแกรม & รอบอบรม</h2>
        <div class="space-x-2">
            <a href="{{ route('admin.programs.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-200">
                ➕ เพิ่มโปรแกรม
            </a>
        </div>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('admin.programs.index') }}" class="mb-4 flex">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาชื่อโปรแกรม" class="flex-1 px-4 py-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-orange-400">
        <button type="submit" class="bg-orange-400 text-white px-4 py-2 rounded-r hover:bg-orange-500 transition-colors duration-200">
            ค้นหา
        </button>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg">
            <thead>
                <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3 font-semibold text-center">ID</th>
                    <th class="px-6 py-3 font-semibold text-center">รูป</th>
                    <th class="px-6 py-3 font-semibold text-left">ชื่อโปรแกรม</th>
                    <th class="px-6 py-3 font-semibold text-center">Category</th>
                    <th class="px-6 py-3 font-semibold text-center">จัดการ</th>
                </tr>
            </thead>
            
            @forelse ($programs as $program)
                <tbody class="divide-y divide-gray-200 border-t" x-data="{ open: false }">
                    <tr class="bg-gray-50 hover:bg-gray-100">
                        <td class="px-6 py-4 text-center">{{ $program->id }}</td>
                        <td class="px-6 py-4 text-center">
                           @if($program->image)
                            <img src="{{ asset('storage/'.$program->image) }}"
                                alt="{{ $program->title }}"
                                class="w-16 h-16 object-cover rounded mx-auto">
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button @click="open = !open" class="flex items-center justify-start space-x-2 w-full text-blue-600 hover:text-blue-800 font-bold text-left">
                                <span>{{ $program->title }}</span>
                                <svg class="w-4 h-4 transition-transform flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-center">{{ $program->category?->name ?? '-' }}</td>
                        
                        {{-- *** ส่วนที่แก้ไข *** --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.programs.edit', $program->id) }}" class="inline-flex items-center justify-center w-24 px-3 py-2 text-xs font-bold text-gray-800 uppercase bg-yellow-400 rounded-full hover:bg-yellow-500 transition-transform transform hover:scale-105">✏️ แก้ไข</a>
                                <a href="{{ route('admin.programs.sessions.create', $program) }}" class="inline-flex items-center justify-center w-32 px-3 py-2 text-xs font-bold text-white uppercase bg-blue-500 rounded-full hover:bg-blue-600 transition-transform transform hover:scale-105">➕ เพิ่มรอบอบรม</a>
                                <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" class="inline-block" onsubmit="return confirm('แน่ใจหรือไม่? การลบโปรแกรมจะลบรอบอบรมทั้งหมดด้วย!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-20 px-3 py-2 text-xs font-bold text-white uppercase bg-red-500 rounded-full hover:bg-red-600 transition-transform transform hover:scale-105">🗑️ ลบ</button>
                                </form>
                            </div>
                        </td>
                        {{-- *** สิ้นสุดส่วนที่แก้ไข *** --}}
                    </tr>

                    <tr class="bg-white" x-show="open" x-transition x-cloak>
                        <td class="py-2"></td> 
                        <td colspan="4" class="p-0">
                            <div class="px-6 py-3">
                                @if($program->sessions->isNotEmpty())
                                    <table class="min-w-full">
                                        {{-- ... โค้ด thead และ tbody ของตารางย่อย (เหมือนเดิม) ... --}}
                                        <thead>
                                            <tr class="text-xs text-gray-500 border-b">
                                                <th class="py-2 text-left font-semibold">รอบที่</th>
                                                <th class="py-2 text-left font-semibold">ระดับ </th>
                                                <th class="py-2 text-left font-semibold">ผู้สอน</th>
                                                <th class="py-2 text-left font-semibold">วันที่</th>
                                                <th class="py-2 text-left font-semibold">สถานที่</th>
                                                <th class="py-2 text-left font-semibold">Capacity</th>
                                                <th class="py-2 text-left font-semibold">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($program->sessions as $session)
                                                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                                                    <td class="py-3">{{ $session->session_number ?? '-' }}</td>
                                                    <td class="py-3">
                                                        @if($session->level)
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                {{ $session->level->name }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="py-3">{{ $session->trainer->name ?? 'N/A' }}</td>
                                                    <td class="py-3">{{ $session->start_at->format('d M Y') }}</td>
                                                    <td class="py-3">{{ $session->location ?? '-'}}</td>
                                                    <td class="py-3">{{ $session->capacity ?? 'N/A' }}</td>
                                                    <td class="py-3">
                                                        <a href="{{ route('admin.programs.sessions.edit', [$program, $session]) }}" class="text-yellow-600 hover:underline ml-2 text-sm">แก้ไข</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-center text-gray-500 py-4">No sessions found for this program.</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                </tbody>
            @empty
                <tbody>
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">ไม่พบโปรแกรม</td></tr>
                </tbody>
            @endforelse
        </table>
    </div>
</div>
@endsection