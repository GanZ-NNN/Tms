<section class="rc-ProductCardCollection container my-5">

    @php
        use Carbon\Carbon;
        $now = Carbon::now();
        $nextMonth = $now->copy()->addMonth();

        // ฟังก์ชันกรอง session ตามเดือน, ยังไม่ completed และเปิดรับสมัครแล้ว
        function filterSessionsByMonth($sessions, $month, $year, $now) {
            return $sessions->filter(fn($s) =>
                $s->start_at &&
                Carbon::parse($s->start_at)->month === $month &&
                Carbon::parse($s->start_at)->year === $year &&
                $s->status !== 'completed' &&
                (!$s->registration_end_at || Carbon::parse($s->registration_end_at)->isFuture()) &&
                (!$s->registration_start_at || Carbon::parse($s->registration_start_at)->lte($now))
            )->sortBy('start_at');
        }
    @endphp

    {{-- 🟢 หลักสูตรของเดือนนี้ --}}
    <h2 class="text-2xl font-bold mb-4 text-green-600">🟢 หลักสูตรของเดือนนี้</h2>
    <div class="course-collection row g-4 justify-content-center">
        @php
            $thisMonthPrograms = $programs->filter(fn($p) => filterSessionsByMonth($p->sessions, $now->month, $now->year, $now)->isNotEmpty());
        @endphp

        @forelse($thisMonthPrograms as $program)
            @php
                $sessionsThisMonth = filterSessionsByMonth($program->sessions, $now->month, $now->year, $now);
                $levelName = $sessionsThisMonth->first()?->level ?? 'ไม่ระบุระดับ';
            @endphp

            <div class="col-12 col-sm-6 col-lg-4" id="program-{{ $program->id }}">
                <div class="course-card bg-white border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column h-100 hover-card">
                    <div class="course-image-wrapper">
                        <img src="{{ $program->image ? asset('storage/' . $program->image) : 'https://via.placeholder.com/400x200' }}" class="card-img-top" alt="{{ $program->title }}">
                    </div>

                    <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                        <h5 class="fw-semibold mb-3 text-center" style="font-size: 1.75rem;">
                            {{ Str::limit($program->title, 60) }}
                        </h5>
                        <p class="card-text text-muted fs-5 text-center">{{ $program->detail }}</p>

                        <div class="mt-3 text-center">
                            <span class="fw-semibold text-dark">{{ ucfirst($levelName) }}</span> ·
                            <span>{{ $program->category->name ?? 'Course' }}</span>
                        </div>

                        <div class="p-3 border-top">
                            <h6 class="fw-bold mb-2">รอบอบรมที่เปิดรับสมัคร:</h6>

                            @forelse($sessionsThisMonth as $session)
                                @php
                                    $regOpen = $session->registration_start_at ? Carbon::parse($session->registration_start_at) : null;
                                    $regClose = $session->registration_end_at ? Carbon::parse($session->registration_end_at) : null;
                                    $canRegister = $regOpen && $regClose ? $now->between($regOpen, $regClose) : false;
                                @endphp

                                <div class="border-bottom py-2 d-flex justify-content-between align-items-start session-item">
                                    <div class="me-2">
                                        <div class="fw-semibold">
                                            {{ $session->title ?? 'รอบที่ ' . $session->session_number }} |
                                            <span class="text-muted small">{{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="far fa-clock"></i> {{ $session->start_at->format('H:i') }} - {{ $session->end_at->format('H:i') }} น. |
                                            <i class="far fa-user"></i> {{ $session->trainer?->name ?? '-' }} |
                                            <i class="fas fa-map-marker-alt"></i> {{ $session->location ?? '-' }} |
                                            <i class="fas fa-users"></i> {{ $session->capacity ?? '-' }}
                                        </div>

                                        @if ($regOpen && $now->lt($regOpen))
                                            <span class="badge bg-primary mt-1">🕓 เปิดรับสมัคร: {{ $regOpen->format('d M Y H:i') }}</span>
                                        @elseif ($canRegister)
                                            <span class="badge bg-success mt-1">✅ เปิดรับสมัคร (ถึง {{ $regClose->format('d M Y H:i') }})</span>
                                        @elseif ($regClose && $now->gte($regClose))
                                            <span class="badge bg-danger mt-1">⛔ ปิดรับสมัครเมื่อ {{ $regClose->format('d M Y H:i') }}</span>
                                        @endif
                                    </div>

                                    <div>
                                        @auth
                                            @php
                                                $userRegistration = $session->registrations->where('user_id', Auth::id())->first();
                                            @endphp

                                            @if ($userRegistration)
                                                <form class="cancel-form" action="{{ route('registrations.cancel', $userRegistration) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm fw-bold cancel-btn">ยกเลิก</button>
                                                </form>
                                            @else
                                                @if ($canRegister)
                                                    <form class="register-form" action="{{ route('sessions.register', $session) }}" method="POST">
                                                        @csrf
                                                        <button type="button" class="btn btn-success btn-sm fw-bold register-btn">ลงทะเบียน</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary btn-sm fw-bold" disabled>ปิดรับสมัคร</button>
                                                @endif
                                            @endif
                                        @else
                                            <div class="d-flex justify-content-center mt-2">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-sm fw-bold login-alert-btn">สมัคร</a>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">ไม่มีรอบอบรมที่เปิดรับสมัครในเดือนนี้</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted fs-5">❌ ไม่มีหลักสูตรที่เปิดรับสมัครในเดือนนี้</p>
        @endforelse
    </div>

    {{-- 🔵 หลักสูตรของเดือนหน้า --}}
    <h2 class="text-2xl font-bold mt-10 mb-4 text-blue-600">🔵 หลักสูตรของเดือนหน้า</h2>
    <div class="course-collection row g-4 justify-content-center">
        @php
            $nextPrograms = $programs->filter(fn($p) => filterSessionsByMonth($p->sessions, $nextMonth->month, $nextMonth->year, $now)->isNotEmpty());
        @endphp

        @forelse($nextPrograms as $program)
            @php
                $sessionsNextMonth = filterSessionsByMonth($program->sessions, $nextMonth->month, $nextMonth->year, $now);
                $levelName = $sessionsNextMonth->first()?->level ?? 'ไม่ระบุระดับ';
            @endphp

            <div class="col-12 col-sm-6 col-lg-4" id="program-{{ $program->id }}">
                <div class="course-card bg-white border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column h-100 hover-card">
                    <div class="course-image-wrapper">
                        <img src="{{ $program->image ? asset('storage/' . $program->image) : 'https://via.placeholder.com/400x200' }}" class="card-img-top" alt="{{ $program->title }}">
                    </div>

                    <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                        <h5 class="fw-semibold mb-3 text-center" style="font-size: 1.75rem;">
                            {{ Str::limit($program->title, 60) }}
                        </h5>
                        <p class="card-text text-muted fs-5 text-center">{{ $program->detail }}</p>

                        <div class="mt-3 text-center">
                            <span class="fw-semibold text-dark">{{ ucfirst($levelName) }}</span> ·
                            <span>{{ $program->category->name ?? 'Course' }}</span>
                        </div>

                        <div class="p-3 border-top">
                            <h6 class="fw-bold mb-2">รอบอบรมที่เปิดรับสมัคร:</h6>

                            @forelse($sessionsNextMonth as $session)
                                @php
                                    $regOpen = $session->registration_start_at ? Carbon::parse($session->registration_start_at) : null;
                                    $regClose = $session->registration_end_at ? Carbon::parse($session->registration_end_at) : null;
                                    $canRegister = $regOpen && $regClose ? $now->between($regOpen, $regClose) : false;
                                @endphp

                                <div class="border-bottom py-2 d-flex justify-content-between align-items-start session-item">
                                    <div class="me-2">
                                        <div class="fw-semibold">
                                            {{ $session->title ?? 'รอบที่ ' . $session->session_number }} |
                                            <span class="text-muted small">{{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="far fa-clock"></i> {{ $session->start_at->format('H:i') }} - {{ $session->end_at->format('H:i') }} น. |
                                            <i class="far fa-user"></i> {{ $session->trainer?->name ?? '-' }} |
                                            <i class="fas fa-map-marker-alt"></i> {{ $session->location ?? '-' }} |
                                            <i class="fas fa-users"></i> {{ $session->capacity ?? '-' }}
                                        </div>

                                        @if ($regOpen && $now->lt($regOpen))
                                            <span class="badge bg-primary mt-1">🕓 เปิดรับสมัคร: {{ $regOpen->format('d M Y H:i') }}</span>
                                        @elseif ($canRegister)
                                            <span class="badge bg-success mt-1">✅ เปิดรับสมัคร (ถึง {{ $regClose->format('d M Y H:i') }})</span>
                                        @elseif ($regClose && $now->gte($regClose))
                                            <span class="badge bg-danger mt-1">⛔ ปิดรับสมัครเมื่อ {{ $regClose->format('d M Y H:i') }}</span>
                                        @endif
                                    </div>

                                    <div>
                                        @auth
                                            @php
                                                $userRegistration = $session->registrations->where('user_id', Auth::id())->first();
                                            @endphp

                                            @if ($userRegistration)
                                                <form class="cancel-form" action="{{ route('registrations.cancel', $userRegistration) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm fw-bold cancel-btn">ยกเลิก</button>
                                                </form>
                                            @else
                                                @if ($canRegister)
                                                    <form class="register-form" action="{{ route('sessions.register', $session) }}" method="POST">
                                                        @csrf
                                                        <button type="button" class="btn btn-success btn-sm fw-bold register-btn">ลงทะเบียน</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-secondary btn-sm fw-bold" disabled>ปิดรับสมัคร</button>
                                                @endif
                                            @endif
                                        @else
                                            <div class="d-flex justify-content-center mt-2">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-sm fw-bold login-alert-btn">สมัคร</a>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">ไม่มีรอบอบรมที่เปิดรับสมัครในเดือนหน้า</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted fs-5">❌ ไม่มีหลักสูตรที่เปิดรับสมัครในเดือนหน้า</p>
        @endforelse
    </div>
</section>

{{-- CSS --}}
<style>
.course-card {
    transition: all 0.25s ease;
    background-color: #fff;
    border: 1px solid #f1f3f4;
}
.course-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
}
.course-image-wrapper {
    background-color: #fafafa;
}
.course-card h5 {
    font-size: 1.25rem;
    color: #212529;
}
.course-card .text-muted {
    color: #6c757d !important;
}
button.btn {
    cursor: pointer;
}
.session-item form, .session-item a {
    margin: 0;
}
</style>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Login alert
    document.querySelectorAll('.login-alert-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'ยังไม่ได้เข้าสู่ระบบ',
                text: 'กรุณาเข้าสู่ระบบก่อนทำการสมัคร',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Login',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        });
    });

    // Register auto submit + success alert
    document.querySelectorAll('.register-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let form = btn.closest('form');
            form.submit();
            Swal.fire({
                title: 'ลงทะเบียนสำเร็จ!',
                text: 'คุณได้ลงทะเบียนเข้าร่วมการอบรมเรียบร้อยแล้ว',
                icon: 'success',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        });
    });

    // Cancel registration with SweetAlert confirm
    document.querySelectorAll('.cancel-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let form = btn.closest('form');
            Swal.fire({
                title: 'ยืนยันการยกเลิก?',
                text: 'คุณต้องการยกเลิกการลงทะเบียนรอบนี้หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
</script>
