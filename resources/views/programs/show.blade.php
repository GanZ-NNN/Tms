<x-app-layout>
    {{-- สามารถกำหนด Title ของหน้าได้ด้วย @section --}}
    @section('title', $program->title)

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">

                {{-- แสดง success message --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card shadow-lg border-0 rounded-3 overflow-hidden">

                    {{-- รูปหลักสูตร --}}
                    @if($program->image)
                        {{-- ตรวจสอบ Path ของรูปภาพให้ถูกต้อง --}}
                        <img src="{{ asset('storage/' . $program->image) }}" 
                             alt="{{ $program->title }}" 
                             class="img-fluid" 
                             style="max-height: 400px; object-fit: cover;">
                    @endif

                    <div class="card-body p-4 p-md-5">
                        {{-- ชื่อหลักสูตร --}}
                        <h1 class="card-title mb-3 fw-bold text-primary">
                            {{ $program->title }}
                        </h1>

                        {{-- รายละเอียดหลักสูตร --}}
                        {{-- เปลี่ยนจาก description เป็น detail --}}
                        <p class="card-text text-muted fs-5">
                            {{ $program->detail }}
                        </p>

                        <hr class="my-4">
                        
                        {{-- แสดงรอบอบรมที่เปิดรับสมัคร --}}
                        <h3 class="fw-bold mb-3">รอบอบรมที่เปิดรับสมัคร</h3>

                        @forelse ($program->sessions as $session)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <div>
                                    <div class="fw-semibold">รอบที่ {{ $session->session_number }} - {{ $session->level?->name }}</div>
                                    <div class="small text-muted">
                                        <i class="far fa-calendar-alt"></i> {{ $session->start_at->format('d M Y') }} | 
                                        <i class="far fa-user"></i> {{ $session->trainer?->name }} |
                                        <i class="fas fa-map-marker-alt"></i> {{ $session->location }}
                                    </div>
                                </div>
                                <div>
                                    {{-- ปุ่มลงทะเบียนสำหรับแต่ละ Session --}}
                                    <form action="{{ route('sessions.register', $session) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success fw-bold">ลงทะเบียน</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">ยังไม่มีรอบอบรมสำหรับหลักสูตรนี้</p>
                        @endforelse

                    </div>
                </div>

                {{-- ปุ่มย้อนกลับ --}}
                {{-- <div class="text-center mt-4">
                    <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary">
                        ← กลับไปยังรายการหลักสูตร
                    </a>
                </div> --}}

            </div>
        </div>
    </div>
</x-app-layout>