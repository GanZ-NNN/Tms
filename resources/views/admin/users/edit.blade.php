@extends('layouts.admin')

@section('title', 'แก้ไขผู้ใช้งาน')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">แก้ไขผู้ใช้งาน: {{ $user->name }}</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ชื่อ</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Password (เว้นว่างหากไม่ต้องการเปลี่ยน)</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg">
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg">
        </div>

        {{-- Role --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Role</label>
            <select name="role" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="admin" {{ old('role', $user->role)=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="trainee" {{ old('role', $user->role)=='trainee' ? 'selected' : '' }}>Trainee</option>
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">Update</button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-colors duration-200">Cancel</a>
        </div>
    </form>
</div>
@endsection
