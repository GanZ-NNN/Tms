<section class="rc-ProductCardCollection container my-5">
    <h2 class="text-r mb-5 fw-bold">หลักสูตรทั้งหมด</h2>

    <div class="course-collection row g-4">
        @forelse($programs as $program)
            <div class="col-md-4 course-card {{ $loop->index >= 6 ? 'd-none extra-course' : '' }}">
                <a href="{{ route('programs.show', ['program' => $program->id]) }}" class="text-decoration-none">
                    <div class="card hover-card shadow-sm border-0 h-100">
                        <div class="position-relative">
                            @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" class="card-img-top" alt="{{ $program->title }}">
                            @else
                                <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="default">
                            @endif
                            <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                {{ $program->category->name ?? 'ทั่วไป' }}
                            </span>
                        </div>
                        <div class="card-body d-flex flex-column text-center">
                            <h5 class="fw-bold mb-2">{{ $program->title }}</h5>
                            <p class="text-muted small flex-grow-1 mb-3">{{ Str::limit($program->detail, 1000) }}</p>
                        </div>
                        <!-- <div class="badge bgg-primary position-absolute bottom-0 end-0 m-3">
                            {{ $session->level->name ?? 'ระดับทั่วไป' }}
                        </div> -->
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center text-muted fs-5">❌ ไม่พบหลักสูตร</p>
        @endforelse
    </div>

    @if($programs->count() > 6)
        <div class="text-center mt-4">
            <button class="btn btn-outline-secondary" id="showMoreBtn">
                Show {{ $programs->count() - 6 }} more
            </button>
        </div>
    @endif
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('showMoreBtn');
    if (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.extra-course').forEach(el => {
                el.classList.remove('d-none');
            });
            btn.style.display = 'none';
        });
    }
});

</script>
