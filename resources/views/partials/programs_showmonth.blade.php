<section class="rc-ProductCardCollection container my-5">

    @php
        use Carbon\Carbon;
        $now = Carbon::now();
        $nextMonth = $now->copy()->addMonth();
    @endphp

    {{-- ฟังก์ชันกรอง session ตามเดือนและสถานะไม่ใช่ completed --}}
    @php
        function filterSessionsByMonth($sessions, $month, $year) {
            return $sessions->filter(fn($s) =>
                Carbon::parse($s->start_at)->month === $month &&
                Carbon::parse($s->start_at)->year === $year &&
                $s->status !== 'completed' // ไม่เอา completed
            )->sortBy('start_at');
        }
    @endphp

    {{-- 🟢 หลักสูตรของเดือนนี้ --}}
    <h2 class="text-2xl font-bold mb-4 text-green-600">🟢 หลักสูตรของเดือนนี้</h2>
    <div class="course-collection row g-4 justify-content-center">
        @php
            $thisMonthPrograms = $programs->filter(fn($p) => filterSessionsByMonth($p->sessions, $now->month, $now->year)->isNotEmpty());
        @endphp

        @forelse($thisMonthPrograms as $program)
            @php
                $levelName = $program->sessions->first()?->level ?? 'ไม่ระบุระดับ';
                $sessionsThisMonth = filterSessionsByMonth($program->sessions, $now->month, $now->year);
            @endphp

            <div class="col-12 col-sm-6 col-lg-4" id="program-{{ $program->id }}">
                <div class="course-card bg-white border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column h-100 hover-card">
                    <div class="course-image-wrapper">
                        @if($program->image)
                            <img src="{{ asset('storage/' . $program->image) }}" class="card-img-top" alt="{{ $program->title }}">
                        @else
                            <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="default">
                        @endif
                    </div>

                    <div class="p-1 flex-grow-1 d-flex flex-column justify-content-between">
                        <h5 class="fw-semibold mb-3 text-center" style="font-size: 1.75rem;">
                            {{ Str::limit($program->title, 60) }}
                        </h5>
                        <p class="card-text text-muted fs-5 text-center">
                            {{ $program->detail }}
                        </p>
                    </div>


                    <div class="p-1 border-top">
                            <span class="fw-semibold text-dark">{{ ucfirst($levelName) }}</span> -
                            <span>{{ $program->category->name ?? 'Course' }}</span>
                        </div>

                        {{-- รอบอบรมที่เปิดรับสมัคร --}}
                        <div class="p-3 border-top">
                            <h6 class="fw-bold">รอบอบรมที่เปิดรับสมัคร:</h6>
                            @forelse($sessionsThisMonth as $session)
                                @php
                                    $canRegister = $session->registration_start_at && $session->registration_end_at
                                        ? $now->between(Carbon::parse($session->registration_start_at), Carbon::parse($session->registration_end_at))
                                        : false;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center border-bottom py-2 session-item">
                                    <div>
                                        <div class="fw-semibold">
                                            {{ $session->title ?? 'รอบที่ ' . $session->session_number }} |
                                            <span class="text-muted fw-normal small ms-2">
                                                {{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="far fa-clock"></i>
                                            {{ optional($session->start_at)->format('H:i') ?? '-' }} -
                                            {{ optional($session->end_at)->format('H:i') ?? '-' }} น. |
                                            <i class="far fa-user"></i> {{ $session->trainer?->name ?? '-' }} |
                                            <i class="fas fa-map-marker-alt"></i> {{ $session->location ?? '-' }} |
                                            <i class="fas fa-users"></i> Capacity: {{ $session->capacity ?? '-' }}
                                        </div>
                                    </div>

                                    <div>
                                        @auth
                                            @php
                                                $userRegistration = $session->registrations->where('user_id', Auth::id())->first();
                                            @endphp

                                            @if ($userRegistration)
                                                <form action="{{ route('registrations.cancel', $userRegistration) }}" method="POST" onsubmit="return confirm('ยืนยันการยกเลิก?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger fw-bold">ยกเลิกการลงทะเบียน</button>
                                                </form>
                                            @else
                                                @if (!$canRegister)
                                                    <button class="btn btn-secondary fw-bold" disabled>Registration Closed</button>
                                                @else
                                                    <form action="{{ route('sessions.register', $session) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success fw-bold">ลงทะเบียน</button>
                                                    </form>
                                                @endif
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary fw-bold">Login เพื่อลงทะเบียน</a>
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">ยังไม่มีรอบอบรมสำหรับเดือนนี้</p>
                            @endforelse
                        </div>


                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted fs-5">❌ ไม่มีหลักสูตรในเดือนนี้</p>
        @endforelse
    </div>

    {{-- 🔵 หลักสูตรของเดือนหน้า --}}
    <h2 class="text-2xl font-bold mt-10 mb-4 text-blue-600">🔵 หลักสูตรของเดือนหน้า</h2>
    <div class="course-collection row g-4 justify-content-center">
        @php
            $nextPrograms = $programs->filter(fn($p) => filterSessionsByMonth($p->sessions, $nextMonth->month, $nextMonth->year)->isNotEmpty());
        @endphp

        @forelse($nextPrograms as $program)
            @php
                $levelName = $program->sessions->first()?->level ?? 'ไม่ระบุระดับ';
                $sessionsNextMonth = filterSessionsByMonth($program->sessions, $nextMonth->month, $nextMonth->year);
            @endphp

            <div class="col-12 col-sm-6 col-lg-4" id="program-{{ $program->id }}">
                <div class="course-card bg-white border-0 shadow-sm rounded-4 overflow-hidden d-flex flex-column h-100 hover-card">
                    <div class="course-image-wrapper">
                        @if($program->image)
                            <img src="{{ asset('storage/' . $program->image) }}" class="card-img-top" alt="{{ $program->title }}">
                        @else
                            <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="default">
                        @endif
                    </div>

                    <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                        <h5 class="fw-semibold mb-3">{{ Str::limit($program->title, 60) }}</h5>
                        <p class="card-text text-muted fs-5">{{ $program->detail }}</p>

                        <div class="mt-2">
                            <h6 class="fw-bold">รอบอบรมที่เปิดรับสมัคร:</h6>
                            @forelse($sessionsNextMonth as $session)
                                @php
                                    $canRegister = $session->registration_start_at && $session->registration_end_at
                                        ? $now->between(Carbon::parse($session->registration_start_at), Carbon::parse($session->registration_end_at))
                                        : false;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center border-bottom py-2 session-item">
                                    <div>
                                        <div class="fw-semibold">
                                            {{ $session->title ?? 'รอบที่ ' . $session->session_number }} |
                                            <span class="text-muted fw-normal small ms-2">
                                                {{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}
                                            </span>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="far fa-clock"></i>
                                            {{ optional($session->start_at)->format('H:i') ?? '-' }} -
                                            {{ optional($session->end_at)->format('H:i') ?? '-' }} น. |
                                            <i class="far fa-user"></i> {{ $session->trainer?->name ?? '-' }} |
                                            <i class="fas fa-map-marker-alt"></i> {{ $session->location ?? '-' }} |
                                            <i class="fas fa-users"></i> Capacity: {{ $session->capacity ?? '-' }}
                                        </div>
                                    </div>

                                    <div>
                                        @auth
                                            @php
                                                $userRegistration = $session->registrations->where('user_id', Auth::id())->first();
                                            @endphp

                                            @if ($userRegistration)
                                                <form action="{{ route('registrations.cancel', $userRegistration) }}" method="POST" onsubmit="return confirm('ยืนยันการยกเลิก?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger fw-bold">ยกเลิกการลงทะเบียน</button>
                                                </form>
                                            @else
                                                @if (!$canRegister)
                                                    <button class="btn btn-secondary fw-bold" disabled>Registration Closed</button>
                                                @else
                                                    <form action="{{ route('sessions.register', $session) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success fw-bold">ลงทะเบียน</button>
                                                    </form>
                                                @endif
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary fw-bold">Login เพื่อลงทะเบียน</a>
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">ยังไม่มีรอบอบรมสำหรับเดือนหน้า</p>
                            @endforelse
                        </div>

                        <div class="mt-3">
                            <span class="fw-semibold text-dark">{{ ucfirst($levelName) }}</span> ·
                            <span>{{ $program->category->name ?? 'Course' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted fs-5">❌ ไม่มีหลักสูตรของเดือนหน้า</p>
        @endforelse
    </div>

</section>

<!-- Styles -->
<style>
.course-card {
    transition: all 0.25s ease;
    background-color: #fff;
    border: 1px solid #f1f3f4;
}
.course-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
}
.course-image-wrapper {
    background-color: #fafafa;
}
.course-card h5 {
    font-size: 1rem;
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('registration_success'))
        Swal.fire({
            title: 'ลงทะเบียนสำเร็จ!',
            text: 'คุณได้ลงทะเบียนเข้าร่วมการอบรมเรียบร้อยแล้ว',
            icon: 'success',
            confirmButtonText: 'ยอดเยี่ยม',
            timer: 3000,
            timerProgressBar: true
        });
    @endif
</script>
