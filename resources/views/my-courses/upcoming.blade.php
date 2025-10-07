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
                                <!-- Cancel Button -->
                                <div class="mt-4 md:mt-0">
                                    <form id="cancel-form-{{ $registration->id }}" action="{{ route('registrations.cancel', $registration) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        {{-- เพิ่ม @click event ของ Alpine.js เข้าไปในปุ่ม --}}
                                        <button type="button" @click.prevent="confirmCancel({{ $registration->id }})" class="text-sm text-red-600 hover:text-red-800 hover:underline focus:outline-none">
                                            ยกเลิกการลงทะเบียน
                                        </button>
                                    </form>
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
                            {{-- <a href="{{ route('programs.index') }}" class="inline-block px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition-colors">
                                ดูหลักสูตรทั้งหมด
                            </a> --}}
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@push('scripts')
<script>
    function confirmCancel(formId) {
        Swal.fire({
            title: 'ยืนยันการยกเลิก?',
            text: "คุณต้องการยกเลิกการลงทะเบียนรอบนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6366f1', // สีม่วง
            cancelButtonColor: '#6b7280', // สีเทา
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยัน ให้ submit form
                document.getElementById('cancel-form-' + formId).submit();
            }
        })
    }

    // Pop-up สำหรับ "ยกเลิกสำเร็จ"
    @if (session('cancel_success'))
        Swal.fire({
            title: 'ยกเลิกสำเร็จ!',
            text: 'การลงทะเบียนของคุณได้ถูกยกเลิกเรียบร้อยแล้ว',
            icon: 'success',
            confirmButtonText: 'รับทราบ'
        })
    @endif
</script>
@endpush