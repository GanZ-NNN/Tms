@extends('layouts.admin') {{-- <-- ใช้ Layout 'admin' เหมือนกับหน้า Users --}}

@section('title', 'จัดการหมวดหมู่') {{-- <-- ตั้งชื่อ Title ของหน้า --}}

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.categories.index') }}" class="mb-6 flex">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาชื่อหมวดหมู่" class="flex-1 px-4 py-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-orange-400">
        <button type="submit" class="bg-orange-400 text-white px-4 py-2 rounded-r hover:bg-orange-500 transition-colors duration-200">ค้นหา</button>
    </form>

    <!-- Main Content -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">หมวดหมู่ทั้งหมด</h2>
            <a href="{{ route('admin.categories.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-200">➕ เพิ่มหมวดหมู่</a>
        </div>
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg">
                <thead>
                    <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3 font-semibold">ID</th>
                        <th class="px-6 py-3 font-semibold">ชื่อหมวดหมู่</th>
                        <th class="px-6 py-3 font-semibold text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($categories as $category)
                    <tr>
                        <td class="px-6 py-4">{{ $category->id }}</td>
                        <td class="px-6 py-4 font-medium">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-400 text-white px-4 py-2 rounded-full hover:bg-yellow-500 transition-colors duration-200">✏️ แก้ไข</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('คุณแน่ใจว่าต้องการลบหมวดหมู่นี้?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition-colors duration-200">🗑️ ลบ</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">ไม่พบหมวดหมู่</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $categories->appends(request()->query())->links() }}</div>
    </div>

</main>
@endsection