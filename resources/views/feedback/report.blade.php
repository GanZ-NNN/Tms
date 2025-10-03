@extends('layouts.admin')

@section('content')
<div id="app">
    <feedback-report :session-id="{{ $sessionId }}"></feedback-report>
</div>
@endsection

@section('scripts')
    @vite('resources/js/app.js')
@endsection
