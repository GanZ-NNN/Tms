@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h2 class="text-2xl font-semibold mb-4">Certificate Details</h2>

    <div class="bg-white p-6 rounded shadow space-y-3">
        <p><strong>Certificate No:</strong> {{ $certificate->cert_no }}</p>
        <p><strong>User:</strong> {{ $certificate->user->name }}</p>
        <p><strong>Session:</strong> {{ $certificate->session->session_number }}</p>
        <p><strong>Issued At:</strong> {{ optional($certificate->issued_at)->format('Y-m-d') }}</p>
        <p><strong>Verification Hash:</strong> {{ $certificate->verification_hash }}</p>
       @if($certificate->pdf_path)
    <a href="{{ route('admin.certificates.download', $certificate) }}" target="_blank"
       class="text-blue-600 underline">View PDF</a>
@endif

    </div>

    <div class="mt-4">
        <a href="{{ route('admin.certificates.index') }}" class="text-gray-600 hover:underline">← Back</a>
    </div>
</div>
@endsection
