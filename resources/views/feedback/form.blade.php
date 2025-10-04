@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Feedback Form</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('feedback.store', ['session' => $session->id]) }}" method="POST">
    @csrf
    <input type="number" name="rating" min="1" max="5" required>
    <textarea name="comment"></textarea>
    <button type="submit">Submit</button>
</form>
</div>
@endsection
