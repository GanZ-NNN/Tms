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
                    <th class="px-6 py-3 font-semibold text-center">ชื่อโปรแกรม</th>
                    <th class="px-6 py-3 font-semibold  text-center">Category</th>
                    <th class="px-6 py-3 font-semibold text-center">Capacity</th>
                    <th class="px-6 py-3 font-semibold text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($programs as $program)
                    {{-- แถวหลักสำหรับแสดงข้อมูล Program --}}
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
                        <td class="px-6 py-4 text-center font-bold">{{ $program->title }}</td>
                        <td class="px-6 py-4 text-center">{{ $program->category?->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">{{ $program->capacity }}</td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ route('admin.programs.edit', $program->id) }}" class="bg-yellow-400 text-white px-4 py-2 rounded-full hover:bg-yellow-500">✏️ แก้ไข</a>
                            <a href="{{ route('admin.programs.sessions.create', $program) }}" class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">➕ เพิ่มรอบอบรม</a>
                            <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" class="inline-block" onsubmit="return confirm('แน่ใจหรือไม่? การลบโปรแกรมจะลบรอบอบรมทั้งหมดด้วย!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600">🗑️ ลบ</button>
                            </form>
                        </td>
                    </tr>

                    {{-- ตรวจสอบว่ามี Session หรือไม่ ถ้ามี ให้แสดงตารางย่อย --}}
                    @if($program->sessions->isNotEmpty())
                        <tr class="bg-white">
                            {{-- คอลัมน์ว่างสำหรับเยื้อง --}}
                            <td class="py-2"></td> 
                            <td colspan="5" class="p-0">
                                <div class="px-6 py-3">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr class="text-xs text-gray-500 border-b">
                                                <th class="py-2 text-left font-semibold">รอบที่</th>
                                                <th class="py-2 text-left font-semibold">ผู้สอน</th>
                                                <th class="py-2 text-left font-semibold">วันที่</th>
                                                <th class="py-2 text-left font-semibold">สถานที่</th>
                                                <th class="py-2 text-left font-semibold">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Loop ซ้อนสำหรับแสดง Session --}}
                                            @foreach($program->sessions as $session)
                                                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                                                    <td class="py-3">{{ $session->session_number ?? '-' }}</td>
                                                    <td class="py-3">{{ $session->trainer->name ?? 'N/A' }}</td>
                                                    <td class="py-3">{{ $session->start_at->format('d M Y') }}</td>
                                                    <td class="py-3">{{ $session->location ?? '-'}}</td>
                                                    <td class="py-3">
                                                        
                                                        <a href="{{ route('admin.programs.sessions.edit', [$program, $session]) }}" class="text-yellow-600 hover:underline ml-2 text-sm">แก้ไข</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endif

                @empty
                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">ไม่พบโปรแกรม</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination: ลบออก เพราะเราใช้ get() แทน -->
    {{-- <div class="mt-6">
        {{ $programs->appends(request()->query())->links() }}
    </div> --}}
</div>
@endsection