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

        // periods array สำหรับเดือนนี้และเดือนหน้า
        $periods = [
            ['label' => '🟢 หลักสูตรของเดือนนี้', 'color' => 'green-600', 'month' => $now],
            ['label' => '🔵 หลักสูตรของเดือนหน้า', 'color' => 'blue-600', 'month' => $nextMonth]
        ];
    @endphp

    @foreach($periods as $period)
        @php
            $programList = $programs->filter(fn($p) => filterSessionsByMonth($p->sessions, $period['month']->month, $period['month']->year, $now)->isNotEmpty());
        @endphp

        <h2 class="text-2xl font-bold mb-4 text-{{ $period['color'] }}">{{ $period['label'] }}</h2>
        <div class="course-collection row g-4 justify-content-center">
            @forelse($programList as $program)
                @php
                    $sessions = filterSessionsByMonth($program->sessions, $period['month']->month, $period['month']->year, $now);
                    $levelName = $sessions->first()?->level ?? 'ไม่ระบุระดับ';
                @endphp

                <div class="col-12 col-sm-6 col-lg-4" id="program-{{ $program->id }}">
                    <div class="course-card bg-white border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column h-100 hover-card program-card"
                        data-title="{{ $program->title }}"
                        data-detail="{{ $program->detail }}"
                        data-image="{{ $program->image ? asset('storage/' . $program->image) : 'https://via.placeholder.com/400x200' }}">

                        <div class="course-image-wrapper">
                            <img src="{{ $program->image ? asset('storage/' . $program->image) : 'https://via.placeholder.com/400x200' }}"
                                class="card-img-top" alt="{{ $program->title }}">
                        </div>

                        <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="fw-semibold mb-3 text-center" style="font-size: 1.5rem;">
                                {{ Str::limit($program->title, 60) }}
                            </h5>

                            <div class="mt-3 p-3 text-center">
                                <span class="fw-semibold text-dark">{{ ucfirst($levelName) }}</span> ·
                                <span>{{ $program->category->name ?? 'Course' }}</span>
                            </div>
                        </div>

                        <div class="p-3 border-top">
                            <h6 class="fw-bold mb-2">รอบอบรมที่เปิดรับสมัคร:</h6>

                            @forelse($sessions as $session)
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
                                            <div class="mb-1"><i class="far fa-clock"></i> {{ $session->start_at->format('H:i') }} - {{ $session->end_at->format('H:i') }} น.</div>
                                            <div class="mb-1"><i class="far fa-user"></i> {{ $session->trainer?->name ?? '-' }}</div>
                                            <div class="mb-1"><i class="fas fa-map-marker-alt"></i> {{ $session->location ?? '-' }}</div>
                                            <div class="mb-0"><i class="fas fa-users"></i> {{ $session->capacity ?? '-' }}</div>
                                        </div>

                                        @if ($regOpen && $now->lt($regOpen))
                                            <span class="badge bg-primary mt-1">🕓 เปิดรับสมัคร: {{ $regOpen->format('d M Y H:i') }}</span>
                                        @elseif ($canRegister)
                                            <span class="badge bg-success mt-1"> เปิดรับสมัคร (ถึง {{ $regClose->format('d M Y H:i') }})</span>
                                        @elseif ($regClose && $now->gte($regClose))
                                            <span class="badge bg-danger mt-1"> ปิดรับสมัครเมื่อ {{ $regClose->format('d M Y H:i') }}</span>
                                        @endif
                                    </div>

                                    <div>
                                        @auth
                                            @php
                                                $userRegistration = $session->registrations->where('user_id', Auth::id())->first();
                                            @endphp

                                            @if ($userRegistration)
                                                <form class="cancel-form text-center" action="{{ route('registrations.cancel', $userRegistration) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="mt-5 btn btn-danger btn-sm fw-bold cancel-btn">ยกเลิก</button>
                                                </form>
                                            @else
                                                @if ($canRegister)
                                                    <form class="register-form text-center" action="{{ route('sessions.register', $session) }}" method="POST">
                                                        @csrf
                                                        <button type="button" class="mt-5 btn btn-success btn-sm fw-bold register-btn">ลงทะเบียน</button>
                                                    </form>
                                                @else
                                                    <button class="mt-5 btn btn-secondary btn-sm fw-bold" disabled>ปิดรับสมัคร</button>
                                                @endif
                                            @endif
                                        @else
                                            <div class="d-flex text-center mt-2">
                                                <a href="javascript:void(0)" class="mt-5 btn btn-primary btn-sm fw-bold login-alert-btn">สมัคร</a>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">ไม่มีรอบอบรมที่เปิดรับสมัคร</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted fs-5">❌ ไม่มีหลักสูตรที่เปิดรับสมัคร</p>
            @endforelse
        </div>
    @endforeach
</section>

{{-- CSS --}}
<style>
.course-card {
    transition: all 0.25s ease;
    border: 1px solid #f1f3f4;
    background-color: #fff;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.course-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
}
.course-image-wrapper {
    background-color: #fafafa;
    flex-shrink: 0;
}
.course-card h5 {
    font-size: 1.25rem;
}
.course-card .text-muted { color: #6c757d !important; }
button.btn, a.btn { cursor: pointer; }
.session-item form, .session-item a { margin: 0; }
</style>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // 🔹 ฟังก์ชันแสดง popup ยืนยัน
    function showSwalConfirm(title, text, icon, confirmText, onConfirm) {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: 'ยกเลิก'
        }).then(result => {
            if (result.isConfirmed && typeof onConfirm === 'function') {
                onConfirm();
            }
        });
    }

    // ✅ ปุ่มสมัคร
    document.querySelectorAll('.register-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const form = btn.closest('form');

            showSwalConfirm('ยืนยันการสมัคร?', 'คุณต้องการสมัครรอบนี้หรือไม่?', 'warning', 'ยืนยัน', () => {
                Swal.fire({
                    title: 'สำเร็จ!',
                    text: 'การลงทะเบียนสำเร็จ',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => form.submit());
            });
        });
    });

    // ✅ ปุ่มยกเลิก
    document.querySelectorAll('.cancel-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const form = btn.closest('form');

            showSwalConfirm('ยืนยันการยกเลิก?', 'คุณต้องการยกเลิกการลงทะเบียนรอบนี้หรือไม่?', 'warning', 'ยืนยัน', () => {
                Swal.fire({
                    title: 'สำเร็จ!',
                    text: 'การยกเลิกการลงทะเบียนสำเร็จ',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => form.submit());
            });
        });
    });

    // ✅ ปุ่มสมัคร (กรณียังไม่ login)
    document.querySelectorAll('.login-alert-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            showSwalConfirm('ยังไม่ได้เข้าสู่ระบบ', 'กรุณาเข้าสู่ระบบก่อนทำการสมัคร', 'warning', 'เข้าสู่ระบบ', () => {
                window.location.href = "{{ route('login') }}";
            });
        });
    });

    // ✅ เปิด popup รายละเอียดเมื่อคลิกการ์ด
    document.querySelectorAll('.program-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.closest('button') || e.target.closest('a')) return; // ป้องกันปุ่มใน card
            const title = card.dataset.title;
            const detail = card.dataset.detail || 'ไม่มีรายละเอียดเพิ่มเติม';
            const image = card.dataset.image;

            Swal.fire({
                title: title,
                html: `
                    <div style="text-align:center;">
                        <img src="${image}" alt="${title}" style="width:100%;max-width:500px;border-radius:12px;margin-bottom:15px;">
                        <div style="text-align:left; font-size:16px; line-height:1.6;">${detail}</div>
                    </div>
                `,
                width: 700,
                confirmButtonText: 'ปิด',
                showCloseButton: true,
            });
        });
    });

});

</script>
