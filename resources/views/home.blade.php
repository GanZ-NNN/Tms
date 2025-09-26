@extends('layouts.app')

@section('title', 'หน้าหลัก - TMS')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center py-5" style="background: linear-gradient(135deg, #4f8ef7, #6fc3f7); color: white;">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">ยินดีต้อนรับสู่ระบบการอบรม</h1>
            <p class="lead mb-4">ค้นหาและสมัครเข้าร่วมหลักสูตรที่เหมาะกับคุณ</p>

            <!-- Search -->
            <form action="{{ route('programs.index') }}" method="GET" class="d-flex justify-content-center flex-wrap gap-2">
                <input type="text" name="keyword" class="form-control form-control-lg shadow-sm w-50" placeholder="🔍 ค้นหาหลักสูตร...">
                <button type="submit" class="btn btn-light btn-lg fw-bold px-4">ค้นหา</button>
            </form>
        </div>
    </section>

    <!-- Program List -->
    <section class="container my-5">
        <h2 class="text-center mb-5 fw-bold">หลักสูตรทั้งหมด</h2>

        <div class="row g-4">
            @forelse($programs as $program)
                <div class="col-sm-6 col-md-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <!-- Program Image -->
                        @if($program->image)
                            <img src="{{ asset('storage/' . $program->image) }}" class="card-img-top" alt="{{ $program->title }}" style="height:200px; object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="default" style="height:200px; object-fit:cover;">
                        @endif

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $program->title }}</h5>
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($program->description, 120) }}</p>
                            <a href="{{ route('programs.show', $program->id) }}" class="btn btn-primary w-100 mt-2">ดูรายละเอียด</a>
                        </div>

                        <!-- Card Footer -->
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
<style>
    /* Card hover effect */
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 0.75rem;
    }
    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    /* Hero responsive adjustments */
    @media (max-width: 768px) {
        .hero-section input.form-control {
            width: 100% !important;
        }
    }
</style>
@endpush
