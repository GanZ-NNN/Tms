@extends('layouts.admin')

@section('title', 'Feedback List')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">All Feedback</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Session</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->id }}</td>
                    <td>{{ $feedback->session->title ?? 'N/A' }}</td>
                    <td>{{ $feedback->rating }}</td>
                    <td>{{ $feedback->comment }}</td>
                    <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No feedback found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $feedbacks->links() }} <!-- pagination -->
</div>
@endsection
