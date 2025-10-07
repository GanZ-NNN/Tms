<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Certificates Collection') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- 1. วนลูปแสดง Certificate ที่ได้รับแล้ว --}}
                @foreach ($issuedCertificates as $certificate)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border-2 border-green-500">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $certificate->session->program->title }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Issued on: {{ $certificate->issued_at->format('d M Y') }}</p>
                                </div>
                                <span class="text-3xl">🏆</span>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('certificates.download', $certificate) }}" class="w-full text-center inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                                    Download Certificate
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- 2. วนลูปแสดง Certificate ที่ "ไม่ได้รับ" --}}
                @foreach ($unissuedCertificates as $unissued)
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-dashed border-gray-400">
                        <div class="p-6 opacity-60">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-700 dark:text-gray-300">{{ $unissued->session->program->title }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Completed on: {{ $unissued->session->end_at->format('d M Y') }}</p>
                                </div>
                                 <span class="text-3xl">🔒</span>
                            </div>
                            <div class="mt-6 text-center bg-yellow-100 dark:bg-yellow-900/50 p-3 rounded-md">
                                <p class="font-semibold text-yellow-800 dark:text-yellow-300">Certificate Not Issued</p>
                                <p class="text-sm text-yellow-700 dark:text-yellow-400">Reason: {{ $unissued->reason }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
             @if($issuedCertificates->isEmpty() && $unissuedCertificates->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <p class="text-gray-500">You have no completed courses yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>