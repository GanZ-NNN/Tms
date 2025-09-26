@extends('layouts.admin') {{-- <-- ใช้ Layout 'admin' ที่ถูกต้อง --}}

@section('title', 'แก้ไขหมวดหมู่') {{-- <-- ตั้งชื่อ Title ของหน้า --}}

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-6">แก้ไขหมวดหมู่: {{ $category->name }}</h1>

    {{-- แสดง Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT') {{-- สำคัญมากสำหรับการแก้ไข --}}

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">ชื่อหมวดหมู่:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
        </div>

        <div class="flex items-center mt-6">
            <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition-colors duration-200">
                อัปเดต
            </button>
            <a href="{{ route('admin.categories.index') }}" class="ml-4 text-gray-600 hover:underline">
                ยกเลิก
            </a>
        </div>
    </form>
</main>
@endsection