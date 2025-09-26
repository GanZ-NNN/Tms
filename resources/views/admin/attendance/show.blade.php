@extends('layouts.admin')

@section('title', 'Attendance')

@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold">Attendance for: {{ $session->title ?? $session->program->title }}</h1>
    <p class="text-gray-600 mb-6">Program: {{ $session->program->title }}</p>

    @if ($session->registrations->isEmpty())
        <p class="text-center text-gray-500 py-8">No registered users for this session.</p>
    @else
        <form action="{{ route('admin.attendance.store', $session) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <p class="text-sm text-gray-500">Please check the box for each trainee who attended the session.</p>
                
                @foreach($session->registrations as $registration)
                    <label class="flex items-center p-4 border rounded-md hover:bg-gray-50 transition-colors duration-200">
                        <input type="checkbox" name="attendees[]" value="{{ $registration->user->id }}"
                               class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                               @checked(in_array($registration->user->id, $attendedUserIds))>
                        
                        <span class="ml-4">
                            <div class="font-medium text-gray-900">{{ $registration->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $registration->user->email }}</div>
                        </span>
                    </label>
                @endforeach
            </div>
            
            <div class="flex justify-end items-center mt-6">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:underline mr-4">Back to Dashboard</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Save Attendance
                </button>
            </div>
        </form>
    @endif
</main>
@endsection