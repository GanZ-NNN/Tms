<section class="container my-5">
    <h2 class="text-center mb-5 fw-bold">หลักสูตรทั้งหมด</h2>

    <div class="swiper program-swiper">
        <div class="swiper-wrapper">
            @forelse($programs as $program)
                <div class="swiper-slide">
                    <div class="card hover-card shadow-sm border-0 h-100">
                        <!-- รูป -->
                        <div class="position-relative">
                            @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}"
                                     class="card-img-top"
                                     alt="{{ $program->title }}">
                            @else
                                <img src="https://via.placeholder.com/400x200"
                                     class="card-img-top"
                                     alt="default">
                            @endif
                            <!-- Badge category -->
                            <span class="badge bg-primary position-absolute top-0 start-0 m-3 rounded-pill px-3 py-2">
                                {{ $program->category->name ?? 'ทั่วไป' }}
                            </span>
                        </div>

                        <!-- เนื้อหา -->
                        <div class="card-body">
                            <h5 class="fw-bold mb-2">{{ $program->title }}</h5>

                            <!-- ราคา -->
                            <p class="text-danger fw-bold mb-2">
                                ราคา: {{ number_format($program->price, 0) }} บาท
                            </p>

                            <!-- คำอธิบาย -->
                            <p class="text-muted small flex-grow-1 mb-3">
                                {{ Str::limit($program->description, 100) }}
                            </p>

                            <!-- ปุ่ม -->
                            <a href="{{ route('programs.show', $program->id) }}"
                               class="btn btn-outline-primary w-100 mt-auto rounded-pill">
                                ดูรายละเอียด
                            </a>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer text-center small text-muted">
                            <div class="d-flex justify-content-between">
                                <span><i class="bi bi-calendar-event me-1"></i>
                                    {{ \Carbon\Carbon::parse($program->start_at)->format('d/m/Y') }}
                                </span>
                                <span><i class="bi bi-eye me-1"></i> {{ $program->views ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted fs-5">❌ ไม่พบหลักสูตร</p>
            @endforelse
        </div>

        <!-- Navigation -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- Pagination -->
        <div class="swiper-pagination mt-3"></div>
    </div>
</section>
