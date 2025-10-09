@extends('layouts.admin')

@section('title', 'Issue Certificate')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">🎓 Issue New Certificate</h1>

    {{-- Success / Error --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.certificates.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        {{-- User --}}
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Select User</label>
            <select name="user_id" id="user_id" class="w-full border rounded p-2"></select>
        </div>

        {{-- Session --}}
        <div>
            <label for="session_id" class="block text-sm font-medium text-gray-700 mb-1">Select Training Session</label>
            <select name="session_id" id="session_id" class="w-full border rounded p-2"></select>
        </div>

        {{-- Issued date --}}
        <div>
            <label for="issued_at" class="block text-sm font-medium text-gray-700 mb-1">Issued Date (optional)</label>
            <input type="date" name="issued_at" id="issued_at"
                   value="{{ old('issued_at', now()->format('Y-m-d')) }}"
                   class="border rounded p-2 w-full">
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('admin.certificates.index') }}" class="text-gray-600 hover:underline">← Back</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Generate Certificate
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // User select2
    $('#user_id').select2({
        placeholder: '-- Choose User --',
        allowClear: true,
        ajax: {
            url: "{{ route('admin.users.search') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) { return { q: params.term }; },
            processResults: function(data) { return { results: data }; }
        },
        minimumInputLength: 1
    });

    // Session select2
    $('#session_id').select2({
        placeholder: '-- Choose Session --',
        allowClear: true,
        ajax: {
            url: "{{ route('admin.sessions.search') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) { return { q: params.term }; },
            processResults: function(data) { return { results: data }; }
        },
        minimumInputLength: 0
    });
});
</script>
@endsection
