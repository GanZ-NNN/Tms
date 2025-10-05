@extends('layouts.app')

@section('title', 'Verify Certificate')

@section('content')
<div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg max-w-md mx-auto">
    <h2 class="text-xl font-semibold mb-4">ตรวจสอบใบรับรอง</h2>

    @if(session('error'))
        <p class="text-red-500 mb-2">{{ session('error') }}</p>
    @endif

    <form action="{{ route('certificates.verify') }}" method="POST" class="space-y-3">
        @csrf
        <div>
            <label for="cert_hash" class="block font-medium">Certificate ID / QR Hash:</label>
            <input type="text" name="cert_hash" id="cert_hash" required
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            ตรวจสอบ
        </button>
    </form>
</div>
@endsection
