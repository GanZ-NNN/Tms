@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold">Feedbacks</h1>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 border rounded">
            <h3 class="font-semibold">Averages</h3>
            <ul>
                <li>Speakers: {{ number_format($averages->speakers ?? 0, 2) }}</li>
                <li>Content: {{ number_format($averages->content ?? 0, 2) }}</li>
                <li>Staff: {{ number_format($averages->staff ?? 0, 2) }}</li>
                <li>Overall: {{ number_format($averages->overall ?? 0, 2) }}</li>
            </ul>
        </div>

        <div class="p-4 border rounded">
            <h3 class="font-semibold">Top Keywords</h3>
            <ol>
                @foreach($topWords as $word => $count)
                    <li>{{ $word }} ({{ $count }})</li>
                @endforeach
            </ol>
        </div>
    </div>

    <div class="mt-6">
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border px-2 py-1">#</th>
                    <th class="border px-2 py-1">Session</th>
                    <th class="border px-2 py-1">User</th>
                    <th class="border px-2 py-1">Scores</th>
                    <th class="border px-2 py-1">Comment</th>
                    <th class="border px-2 py-1">Submitted</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedbacks as $f)
                    <tr>
                        <td class="border px-2 py-1">{{ $f->id }}</td>
                        <td class="border px-2 py-1">{{ $f->trainingSession->title ?? $f->session_id }}</td>
                        <td class="border px-2 py-1">{{ $f->user->name ?? $f->user_id }}</td>
                        <td class="border px-2 py-1">
                            S: {{ $f->speakers }} | C: {{ $f->content }} | St: {{ $f->staff }} | O: {{ $f->overall }}
                        </td>
                        <td class="border px-2 py-1">{{ Str::limit($f->comment, 120) }}</td>
                        <td class="border px-2 py-1">{{ $f->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $feedbacks->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
