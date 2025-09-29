<section class="rc-ProductCardCollection container my-5">
    <h2 class="text-r mb-5 fw-bold">หลักสูตรทั้งหมด</h2>

    <div class="course-collection">
        @forelse($programs as $program)
            <div class="course-card {{ $loop->index >= 6 ? 'd-none extra-course' : '' }}">
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
                        <p class="text-muted small flex-grow-1 mb-3">{{ Str::limit($program->detail, 100) }}</p>
                        <p class="text-secondary">{{ $program->level ?? 'Beginner' }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted fs-5">❌ ไม่พบหลักสูตร</p>
        @endforelse
    </div>

    <!-- Show more button -->
    @if($programs->count() > 6)
        <div class="ShowMoreGridSection-button-wrapper text-center mt-4">
            <button class="btn btn-outline-secondary" id="showMoreBtn">
                Show {{ $programs->count() - 6 }} more
            </button>
        </div>
    @endif
</section>
