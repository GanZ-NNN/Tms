<!-- resources/views/feedback/form.blade.php -->
@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
    <feedback-form :session-id="{{ $session->id }}"></feedback-form>
</div>
@endsection
