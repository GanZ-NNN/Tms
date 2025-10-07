<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('หลักสูตรที่กำลังเรียน / จะมาถึง') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">
                    
                    @forelse ($upcomingSessions as $registration)
                        <div class="border-t first:border-t-0 pt-6 first:pt-0">
                            <div class="flex flex-col md:flex-row md:justify-between">
                                <!-- Course Info -->
                                <div>
                                    <h3 class="font-bold text-lg text-indigo-600 dark:text-indigo-400">
                                        <a href="{{ route('programs.show', $registration->session->program) }}" class="hover:underline">
                                            {{ $registration->session->program->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ $registration->session->title ?? 'รอบที่ ' . $registration->session->session_number }}
                                    </p>
                                </div>
                                <!-- Cancel Button Logic -->
                                <div class="mt-4 md:mt-0">
                                    
                                    {{-- *** ส่วนที่แก้ไข *** --}}
                                    @if (now()->lt($registration->session->registration_end_at))
                                        {{-- ใช้ onsubmit แบบคลาสสิกที่ทำงานได้แน่นอน --}}
                                        <form action="{{ route('registrations.cancel', $registration) }}" method="POST" onsubmit="confirmCancel(event, this)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 hover:underline focus:outline-none">
                                                ยกเลิกการลงทะเบียน
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-sm text-gray-400">เลยกำหนดการยกเลิก</span>
                                    @endif
                                    {{-- *** สิ้นสุดส่วนที่แก้ไข *** --}}

                                </div>
                            </div>
                            <!-- Session Details -->
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 space-x-4">
                                <span>🗓️ <strong>Date:</strong> {{ $registration->session->start_at->format('d M Y') }}</span>
                                <span>👨‍🏫 <strong>Trainer:</strong> {{ $registration->session->trainer->name ?? 'N/A' }}</span>
                                <span>📍 <strong>Location:</strong> {{ $registration->session->location ?? 'N/A' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400 mb-4">คุณยังไม่มีหลักสูตรที่กำลังจะมาถึง</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- *** เพิ่ม Script ทั้งหมดที่จำเป็นเข้ามาในหน้านี้โดยตรง *** --}}
<!-- SweetAlert2 JS Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ฟังก์ชันสำหรับแสดง Pop-up ยืนยันการยกเลิก
    function confirmCancel(event, form) {
        event.preventDefault(); // หยุดการ submit form ทันที
        
        Swal.fire({
            title: 'ยืนยันการยกเลิก?',
            text: "คุณต้องการยกเลิกการลงทะเบียนรอบนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ใช่, ยกเลิกเลย',
            cancelButtonText: 'ไม่'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยัน ค่อยสั่งให้ form submit
                form.submit();
            }
        });
    }

    // ใช้ IIFE เพื่อรันโค้ดแสดง Pop-up "ยกเลิกสำเร็จ" ทันที
    (function () {
        @if (session('cancel_success'))
            Swal.fire({
                title: 'ยกเลิกสำเร็จ!',
                text: 'การลงทะเบียนของคุณได้ถูกยกเลิกแล้ว',
                icon: 'success',
                confirmButtonText: 'รับทราบ'
            });
        @endif
    })();
</script>