<section class="rc-ProductCardCollection container my-5">
    <h2 class="text-r mb-5 fw-bold">หลักสูตรทั้งหมด</h2>

    <div class="course-collection row g-4 justify-content-center">
        @forelse($programs as $program)
            <div class="col-12 col-sm-6 col-lg-4 {{ $loop->index >= 6 ? 'd-none extra-course' : '' }}">
                <a href="{{ route('programs.show', ['program' => $program->id]) }}" class="text-decoration-none text-dark">
                    <div class="course-card bg-white border-0 shadow-sm rounded-4 overflow-hidden h-100 d-flex flex-column hover-card">

                        <!-- ✅ รูปภาพหลักสูตร -->
                        <div class="course-image-wrapper">
                            @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" class="card-img-top" alt="{{ $program->title }}">
                            @else
                                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="default">
                            @endif
                        </div>

                        <!-- ✅ เนื้อหาหลัก -->
                        <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">

                            <!-- 🔹 ชื่อหลักสูตร -->
                            <h5 class="fw-semibold mb-2" style="min-height: 48px; line-height: 1.4;">
                                {{ Str::limit($program->title, 60) }}
                            </h5>

                            <!-- 🔹 ระดับ (Beginner / Intermediate / Expert) + ประเภทหลักสูตร -->
                            @php
                             $levelName = $program->sessions->first()->level ?? 'ไม่ระบุระดับ';
                            @endphp

                            <div class="mt-auto pt-2 border-top d-flex align-items-center justify-content-start gap-2 small text-muted">
                                <span class="fw-semibold text-dark">
                                    {{ ucfirst($levelName) }}
                                </span>
                                <span>·</span>
                                <span>{{ $program->category->name ?? 'Course' }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center text-muted fs-5">❌ ไม่พบหลักสูตร</p>
        @endforelse
    </div>

    <!-- ✅ ปุ่ม Show more -->
    @if($programs->count() > 6)
        <div class="text-center mt-4">
            <button class="btn btn-outline-dark rounded-pill px-4 py-2" id="showMoreBtn">
                แสดงหลักสูตรเพิ่มอีก {{ $programs->count() - 6 }}
            </button>
        </div>
    @endif
</section>

<!-- ✅ JS สำหรับ Show More -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('showMoreBtn');
    if (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.extra-course').forEach(el => el.classList.remove('d-none'));
            btn.style.display = 'none';
        });
    }
});
</script>

<!-- ✅ CSS Minimal Professional Style -->
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
</style>
