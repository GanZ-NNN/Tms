@extends('layouts.app')

@section('title', 'หน้าหลัก - TMS')

@section('content')
    <!-- Hero / Banner Section -->
    <section class="banner-section" style="background-image: url('{{ asset('assets/img/410_devtai.jpg') }}'); >
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Content: Search + Text -->
                <div class="col-lg-7">
                    <div class="section-search">
                        <h1>ค้นหาหลักสูตรที่คุณต้องการ<br><span>ได้ที่นี่ !!</span></h1>
                        <p>หลักสูตร การอบรม ประเภทการอบรม ค้นหาได้อย่างรวดเร็ว</p>

                        <!-- Search Form -->
                        <form action="{{ route('programs.index') }}" method="GET" class="d-flex flex-wrap gap-2 mt-4">
                            <div class="flex-grow-1">
                                <input type="text" name="keyword" class="form-control form-control-lg shadow-sm" placeholder="🔍 ค้นหาหลักสูตร...">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg fw-bold px-4">ค้นหา</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Content: Image / Illustration -->
                <!-- <div class="col-lg-5">
                    <div class="banner-imgs">
                        <img src="{{ asset('assets/img/Monogram-Logo-02.png') }}" alt="Illustration" class="img-fluid">
                    </div>
                </div> -->
            </div>
    </section>

    <!-- Program List -->
    <section class="container my-5">
        <h2 class="text-center mb-5 fw-bold">หลักสูตรทั้งหมด</h2>

        <div class="row g-4">
            @forelse($programs as $program)
                <div class="col-sm-6 col-md-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        @if($program->image)
                            <img src="{{ asset('storage/' . $program->image) }}" class="card-img-top" alt="{{ $program->title }}" style="height:200px; object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="default" style="height:200px; object-fit:cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $program->title }}</h5>
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($program->description, 120) }}</p>
                            <a href="{{ route('programs.show', $program->id) }}" class="btn btn-primary w-100 mt-2">ดูรายละเอียด</a>
                        </div>
                        <div class="card-footer text-muted small text-center">
                            เริ่ม: {{ \Carbon\Carbon::parse($program->start_at)->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted fs-5">❌ ไม่พบหลักสูตร</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $programs->links('pagination::bootstrap-5') }}
        </div>
    </section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush
