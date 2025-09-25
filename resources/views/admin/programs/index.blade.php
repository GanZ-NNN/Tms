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
                <tr>
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
                    <td class="px-6 py-4 text-center">{{ $program->title }}</td>
                    <td class="px-6 py-4 text-center">{{ $program->category?->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">{{ $program->capacity }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('admin.programs.edit', $program->id) }}" class="bg-yellow-400 text-white px-4 py-2 rounded-full hover:bg-yellow-500 transition-colors duration-200">✏️ แก้ไข</a>

                        <!-- ปุ่มเพิ่มรอบอบรม -->
                         <a href="{{ route('admin.programs.sessions.create', $program) }}" class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition-colors duration-200">
                            ➕ เพิ่มรอบอบรม
                        </a>


                        <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจว่าต้องการลบโปรแกรมนี้?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition-colors duration-200">🗑️ ลบ</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">ไม่พบโปรแกรม</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $programs->appends(request()->query())->links() }}
    </div>
</div>
@endsection
