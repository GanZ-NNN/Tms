@extends('layouts.admin')
@section('title', 'Registrations')
@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold">Registrations for: {{ $session->program->title }}</h1>
    <p class="text-muted mb-4">{{ $session->title ?? 'รอบที่ '.$session->session_number }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($session->registrations as $registration)
                <tr>
                    <td>{{ $registration->user->name }}</td>
                    <td>{{ $registration->user->email }}</td>
                    <td>{{ $registration->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">No registrations yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-4">&larr; Back to Dashboard</a>
</main>
@endsection
