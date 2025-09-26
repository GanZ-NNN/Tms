@extends('layouts.admin')

@section('title', 'เพิ่มหลักสูตร')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">เพิ่มหลักสูตร</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Category</label>
            <select name="category_id" class="w-full px-4 py-2 border rounded-lg">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Detail --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Detail</label>
            <textarea name="detail" class="w-full px-4 py-2 border rounded-lg">{{ old('detail') }}</textarea>
        </div>

        {{-- Capacity --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Capacity</label>
            <input type="number" name="capacity" value="{{ old('capacity') }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Image --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Image</label>
            <input type="file" name="image" class="w-full">
        </div>

        {{-- Buttons --}}
        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                บันทึก
            </button>
            <a href="{{ route('admin.programs.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-colors duration-200">
                ยกเลิก
            </a>
        </div>
    </form>
</div>
@endsection
