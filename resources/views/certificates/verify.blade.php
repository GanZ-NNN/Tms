@extends('layouts.app')

@section('title', 'Certificate Verification')

@section('content')
<div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg max-w-md mx-auto text-center">
    @if($valid)
        <h2 class="text-2xl font-bold text-green-600 mb-3">✅ ใบรับรองถูกต้อง</h2>
        <p class="text-lg">{{ $certificate->user->name }} ผ่านหลักสูตร <strong>{{ $certificate->session->program->title }}</strong></p>
        <p class="text-sm text-gray-500 mt-2">Issued on: {{ $certificate->issued_at->format('d M Y') }}</p>
    @else
        <h2 class="text-2xl font-bold text-red-600 mb-3">❌ ใบรับรองไม่ถูกต้อง</h2>
        <p class="text-gray-500">กรุณาตรวจสอบ Certificate ID / QR อีกครั้ง</p>
    @endif
</div>
@endsection
