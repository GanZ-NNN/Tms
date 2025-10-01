@extends('layouts.admin')
@section('title', 'Feedback Details')
@section('content')
<main class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Feedback Details</h1>
            <p class="text-gray-600">{{ $session->title ?? $session->program->title }}</p>
        </div>
        <div>
            <a href="{{ route('admin.reports.feedback.index') }}" class="btn btn-secondary mr-2">&larr; Back to Overview</a>
            <a href="{{ route('admin.reports.feedback.export', $session) }}" class="btn btn-success">Export to CSV</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="text-left ...">
                    <th class="px-6 py-3 ...">User</th>
                    <th class="px-6 py-3 ...">Rating</th>
                    <th class="px-6 py-3 ...">Comment</th>
                    <th class="px-6 py-3 ...">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y ...">
                @forelse ($session->feedback as $item)
                <tr>
                    <td class="px-6 py-4">{{ $item->user->name }}</td>
                    <td class="px-6 py-4 font-bold">{{ $item->rating }}/5</td>
                    <td class="px-6 py-4 italic">"{{ $item->comment ?? '-' }}"</td>
                    <td class="px-6 py-4">{{ $item->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center ...">No feedback for this session.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection
