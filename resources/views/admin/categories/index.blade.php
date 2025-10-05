@extends('layouts.admin')

@section('title', 'จัดการ Categories ')

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg" x-data="{ tab: 'categories' }">

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 mb-6 flex space-x-4">
        <button
            @click="tab = 'categories'"
            :class="tab === 'categories'
                ? 'text-orange-400 border-b-2 border-orange-400 font-semibold'
                : 'text-gray-500 font-medium hover:text-orange-400'"
            class="py-2 px-4"
        >หมวดหมู่</button>

        {{-- <button
            @click="tab = 'levels'"
            :class="tab === 'levels'
                ? 'text-orange-400 border-b-2 border-orange-400 font-semibold'
                : 'text-gray-500 font-medium hover:text-orange-400'"
            class="py-2 px-4"
        >Level</button>
    </div>

    <!-- Categories Table -->
    <div x-show="tab === 'categories'" x-cloak>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">หมวดหมู่ทั้งหมด</h2>
            <a href="{{ route('admin.categories.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">➕ เพิ่มหมวดหมู่</a>
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
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">ชื่อหมวดหมู่</th>
                        <th class="px-6 py-3 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($categories as $category)
                    <tr>
                        <td class="px-6 py-4">{{ $category->id }}</td>
                        <td class="px-6 py-4">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500">✏️ แก้ไข</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('ลบหมวดหมู่นี้?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">🗑️ ลบ</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-gray-500 py-4">ไม่พบหมวดหมู่</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $categories->appends(request()->query())->links() }}</div>
    </div>

    <!-- Levels Table -->
    {{-- <div x-show="tab === 'levels'" x-cloak>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">ละดับ ทั้งหมด</h2>
            <a href="{{ route('admin.levels.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">➕ เพิ่ม Level</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg">
                <thead>
                    <tr class="text-left text-sm text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">ละดับ</th>
                        <th class="px-6 py-3 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($levels as $level)
                    <tr>
                        <td class="px-6 py-4">{{ $level->id }}</td>
                        <td class="px-6 py-4">{{ $level->name }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.levels.edit', $level) }}" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500">✏️ แก้ไข</a>
                            <form action="{{ route('admin.levels.destroy', $level) }}" method="POST" class="inline-block" onsubmit="return confirm('ลบ Level นี้?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">🗑️ ลบ</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-gray-500 py-4">ไม่พบ Level</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $levels->appends(request()->query())->links() }}</div>
    </div> --}}

</main>
@endsection
