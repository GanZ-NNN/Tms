@extends('layouts.admin')
@section('title', 'Feedback Report Overview')
@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-6">Feedback Report Overview</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="text-left ...">
                    <th class="px-6 py-3 ...">Session / Program</th>
                    <th class="px-6 py-3 ...">Submissions</th>
                    <th class="px-6 py-3 ...">Average Rating</th>
                    <th class="px-6 py-3 ... text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y ...">
                @forelse ($sessions as $session)
                <tr>
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $session->title ?? $session->program->title }}</div>
                        <small class="text-muted">{{ $session->program->title }}</small>
                    </td>
                    <td class="px-6 py-4">{{ $session->feedback_count }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold">{{ number_format($session->feedback_avg_rating, 1) }}</span> / 5.0
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.reports.feedback.details', $session) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center ...">No feedback has been submitted yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $sessions->links() }}</div>
</main>
@endsection
