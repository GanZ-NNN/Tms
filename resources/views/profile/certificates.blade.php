@extends('layouts.app')

@section('title', 'My Certificates')

@section('content')
<div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">My Certificates</h2>

    @forelse($certificates as $certificate)
        @php
            $session = $certificate->session;
        @endphp

        <div class="flex justify-between items-center p-4 mb-3 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-900">
            <div>
                <p class="font-semibold text-lg">{{ $session->program->title }}</p>
                <p class="text-sm text-gray-500">Completed on: {{ $certificate->issued_at ? $certificate->issued_at->format('d M Y') : '-' }}</p>
                @if($certificate->verification_hash)
                    <p class="text-sm text-gray-400">Certificate ID: {{ $certificate->verification_hash }}</p>
                @endif
            </div>

            <div class="flex items-center space-x-2">
                {{-- ปุ่มดาวน์โหลด PDF --}}
                @if($certificate->pdf_path && \Illuminate\Support\Facades\Storage::exists($certificate->pdf_path))
                    <a href="{{ route('certificates.download', $certificate) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Download
                    </a>
                @else
                    <span class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed">Not Ready</span>
                @endif

                {{-- ปุ่ม Verify QR / Hash --}}
                @if($certificate->verification_hash)
                    <a href="{{ route('certificates.verify.hash', $certificate->verification_hash) }}" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Verify QR
                    </a>
                @endif
            </div>
        </div>

    @empty
        <p class="text-gray-500">You have no certificates yet.</p>
    @endforelse
</div>
@endsection

