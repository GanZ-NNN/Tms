@extends('layouts.admin')

@section('content')
<h3>Generate New Certificate</h3>

<form action="{{ route('admin.certificates.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="user_id" class="form-label">User</label>
        <select name="user_id" id="user_id" class="form-select">
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="session_id" class="form-label">Training Session</label>
        <select name="session_id" id="session_id" class="form-select">
            @foreach($sessions as $session)
                <option value="{{ $session->id }}">{{ $session->title }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Generate</button>
</form>
@endsection
