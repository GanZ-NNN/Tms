<x-app-layout>
    {{-- สามารถกำหนด Title ของหน้าได้ด้วย @section --}}
    @section('title', $program->title)

   <div class="container my-5" style="min-height: 900px;">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-10">
                
                {{-- ไม่ต้องมี Logic ปุ่มตรงนี้ --}}

                <div class="card h-100 shadow-sm border-0 rounded-lg course-card">

                    {{-- รูปหลักสูตร --}}
                    @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}"
                             alt="{{ $program->title }}"
                             class="img-fluid d-block mx-auto"
                             style="max-height: 400px; object-fit: cover;">
                    @endif

                    <div class="card-body p-4 p-md-5">
                        {{-- ชื่อหลักสูตร --}}
                        <h1 class="card-title mb-3 fw-bold text-primary">
                            {{ $program->title }}
                        </h1>

                        {{-- รายละเอียดหลักสูตร --}}
                        <p class="card-text text-muted fs-5">
                            {{ $program->detail }}
                        </p>

                        <hr class="my-4">

                        {{-- แสดงรอบอบรมที่เปิดรับสมัคร --}}
                        <h3 class="fw-bold mb-3">รอบอบรมที่เปิดรับสมัคร</h3>

                        @forelse ($program->sessions as $session)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                {{-- ส่วนแสดงข้อมูล Session --}}
                                <div>
                                    <div class="fw-semibold">{{ $session->title ?? 'รอบที่ ' . $session->session_number }} - {{ $session->level?->name }}</div>
                                    <div class="small text-muted">
                                        <i class="far fa-calendar-alt"></i> {{ $session->start_at->format('d M Y') }} | 
                                        <i class="far fa-user"></i> {{ $session->trainer?->name }} |
                                        <i class="fas fa-map-marker-alt"></i> {{ $session->location }}
                                    </div>
                                </div>
                                
                                {{-- *** ย้าย Logic ปุ่มที่ถูกต้องมาไว้ที่นี่ *** --}}
                                <div>
                                    @auth
                                        @php
                                            // ค้นหาว่า user ปัจจุบันได้ลงทะเบียนใน session นี้หรือไม่
                                            $userRegistration = $session->registrations->where('user_id', Auth::id())->first();
                                        @endphp

                                        @if ($userRegistration)
                                            {{-- ถ้าลงทะเบียนแล้ว --}}
                                            @if ($session->status === 'completed')
                                                <button class="btn btn-secondary fw-bold" disabled>Session Completed</button>
                                            @else
                                                <form action="{{ route('registrations.cancel', $userRegistration) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger fw-bold">ยกเลิกการลงทะเบียน</button>
                                                </form>
                                            @endif
                                        @else
                                            {{-- ถ้ายังไม่ได้ลงทะเบียน --}}
                                            @if ($session->status === 'completed')
                                                <button class="btn btn-secondary fw-bold" disabled>Registration Closed</button>
                                            @else
                                                <form action="{{ route('sessions.register', $session) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success fw-bold">ลงทะเบียน</button>
                                                </form>
                                            @endif
                                        @endif
                                    @else
                                        {{-- ถ้ายังไม่ได้ Login --}}
                                        <a href="{{ route('login') }}" class="btn btn-primary fw-bold">Login เพื่อลงทะเบียน</a>
                                    @endauth
                                </div>
                                {{-- *** สิ้นสุดส่วน Logic ปุ่ม *** --}}
                            </div>
                        @empty
                            <p class="text-muted">ยังไม่มีรอบอบรมสำหรับหลักสูตรนี้</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>