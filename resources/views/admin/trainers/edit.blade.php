@extends('layouts.admin')

@section('title', 'แก้ไขผู้สอน')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">แก้ไขผู้สอน: {{ $trainer->name }}</h1>

    {{-- แสดง Error --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ชื่อ</label>
            <input type="text" name="name" value="{{ old('name', $trainer->name) }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $trainer->email) }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Phone Number --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">เบอร์โทร</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $trainer->phone_number) }}"
                   class="w-full px-4 py-2 border rounded-lg">
        </div>

        {{-- Bio --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Bio</label>
            <textarea name="bio" rows="4"
                      class="w-full px-4 py-2 border rounded-lg">{{ old('bio', $trainer->bio) }}</textarea>
        </div>

        {{-- Profile Image --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Profile Image</label>
            @if($trainer->profile_image_path)
                <img src="{{ asset('storage/' . $trainer->profile_image_path) }}"
                     alt="Profile Image" class="mb-2 w-32 h-32 object-cover rounded">
            @endif
            <input type="file" name="profile_image_path" class="w-full">
        </div>

        {{-- Buttons --}}
        <div class="flex space-x-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                Update
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-colors duration-200">
               Cancel
            </a>
        </div>
    </form>
</div>
@endsection
