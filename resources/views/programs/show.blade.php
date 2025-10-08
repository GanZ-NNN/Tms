<x-app-layout>
    @section('title', $program->title)

    <div class="container my-5" style="min-height: 900px;">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">

                <div class="card h-100 shadow-lg border-0 rounded-lg course-card">

                    {{-- รูปหลักสูตร (ปรับปรุงส่วนนี้) --}}
                    {{-- 1. เพิ่ม div ห่อหุ้มที่มีคลาส course-image-wrapper เพื่อควบคุมสัดส่วน --}}
                    <div class="course-image-wrapper">
                        @if($program->image)
                            <img src="{{ asset('storage/' . $program->image) }}"
                                alt="{{ $program->title }}"
                                class="img-fluid" {{-- ลบคลาส w-100 ออกแล้วใช้ CSS ควบคุมแทน --}}
                            >
                        @else
                            <div class="mock-image-container">
                                ภาพประกอบหลักสูตร
                            </div>
                        @endif
                    </div>

                    <div class="card-body p-4 p-md-5">
                        {{-- ชื่อหลักสูตร --}}
                        <h1 class="card-title mb-3 fw-bold text-primary">
                            {{ $program->title }}
                        </h1>

                        {{-- รายละเอียดหลักสูตร --}}
                        <div class="course-details-list text-muted fs-5">
                            {!! $program->detail !!}
                        </div>
                        <hr class="my-4">

                        {{-- แสดงรอบอบรมที่เปิดรับสมัคร --}}
                        <h3 class="fw-bold mb-4">รอบอบรมที่เปิดรับสมัคร</h3>

                        @forelse ($program->sessions as $session)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3 session-item">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $session->title ?? 'รอบที่ ' . $session->session_number }} |
                                        <span class="text-muted fw-normal small ms-3">
                                            {{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="small text-muted">
                                        <i class="far fa-clock"></i>
                                            {{ optional($session->start_at)->format('H:i') ?? 'ไม่ระบุเวลา' }} -
                                            {{ optional($session->end_at)->format('H:i') ?? 'ไม่ระบุเวลา' }} น. |
                                        <i class="far fa-user"></i> {{ $session->trainer?->name ?? 'ไม่ระบุผู้สอน' }} |
                                        <i class="fas fa-map-marker-alt"></i> {{ $session->location ?? '-' }}
                                    </div>
                                </div>

                                {{-- Logic ปุ่ม --}}
                                <div>
                                    @auth
                                        @php
                                            $userRegistration = $session->registrations->where('user_id', Auth::id())->first();
                                        @endphp

                                        @if ($userRegistration)
                                            @if ($session->status === 'completed')
                                                <button class="btn btn-secondary fw-bold" disabled>Session Completed</button>
                                            @else
                                            <form action="{{ route('registrations.cancel', $registration) }}" method="POST" onsubmit="confirmCancel(event, this)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 ...">
                                                    ยกเลิกการลงทะเบียน
                                                </button>
                                            </form>
                                            @endif
                                        @else
                                            @if ($session->status === 'completed')
                                                <button class="btn btn-secondary fw-bold" disabled>Registration Closed</button>
                                            @else
                                                <form action="{{ route('sessions.register', $session) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success fw-bold">สมัครรอบอบรมนี้</button>
                                                </form>
                                            @endif
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary fw-bold">Login เพื่อลงทะเบียน</a>
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">ยังไม่มีรอบอบรมสำหรับหลักสูตรนี้</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ✅ CSS สำหรับกำหนดสัดส่วนรูปภาพ 16:9 --}}
    <style>
    .course-image-wrapper {
        /* ใช้เทคนิค Padding Top เพื่อกำหนดสัดส่วน 16:9 */
        position: relative;
        padding-top: 56.25%; /* (9 / 16) * 100% = 56.25% */
        height: 0; /* ต้องกำหนดเป็น 0 เพื่อให้ padding-top ทำงาน */
        overflow: hidden;
    }

    .course-image-wrapper img {
        /* ทำให้รูปภาพอยู่ภายในกรอบสัดส่วนที่กำหนด */
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover; /* สำคัญ: ครอบคลุมพื้นที่โดยไม่ทำให้รูปบิดเบือน */
        border-top-left-radius: 0.5rem; /* ทำให้มุมมนตาม Card */
        border-top-right-radius: 0.5rem; /* ทำให้มุมมนตาม Card */
    }
    .mock-image-container {
        /* สไตล์สำหรับรูปภาพจำลองเมื่อไม่มีรูปภาพจริง */
        padding-top: 56.25%;
        background-color: #f1f3f4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 1.25rem;
        font-weight: bold;
    }
    </style>

 @push('scripts')
<script>
    // ฟังก์ชันสำหรับแสดง Pop-up ยืนยันการยกเลิก
    function confirmCancel(event, form) {
        event.preventDefault(); // หยุดการ submit form ตามปกติ
        
        Swal.fire({
            title: 'ยืนยันการยกเลิก?',
            text: "คุณต้องการยกเลิกการลงทะเบียนรอบนี้หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545', // สีแดง Bootstrap
            cancelButtonColor: '#6c757d', // สีเทา Bootstrap
            confirmButtonText: 'ใช่, ยกเลิกเลย',
            cancelButtonText: 'ไม่'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยัน ให้ submit form นั้นๆ
                form.submit();
            }
        })
    }

    // ตรวจสอบ Session Flash Data แล้วแสดง Pop-up
    @if (session('registration_success'))
        Swal.fire({
            title: 'ลงทะเบียนสำเร็จ!',
            text: 'คุณได้ลงทะเบียนเข้าร่วมการอบรมเรียบร้อยแล้ว',
            icon: 'success',
            confirmButtonText: 'ยอดเยี่ยม'
        });
    @elseif (session('cancel_success'))
        Swal.fire({
            title: 'ยกเลิกสำเร็จ!',
            text: 'การลงทะเบียนของคุณได้ถูกยกเลิกเรียบร้อยแล้ว',
            icon: 'success', // ใช้ success ก็ได้เพื่อให้ดูดี
            confirmButtonText: 'รับทราบ'
        });
    @endif
</script>
@endpush
</x-app-layout>
