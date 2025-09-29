<form action="{{ route('home') }}" method="GET" class="d-flex flex-wrap gap-2 mt-4">
    <div class="flex-grow-1">
        <input
            type="text"
            name="keyword"
            class="form-control form-control-lg shadow-sm"
            placeholder="🔍 ค้นหาหลักสูตร..."
            value="{{ request('keyword') }}" <!-- เติมตรงนี้เพื่อโชว์ค่าเดิม -->
        >
    </div>
    <div>
        <button type="submit" class="btn btn-primary btn-lg fw-bold px-4">ค้นหา</button>
    </div>
</form>

@if($programs->count())
    <div class="row">
        @foreach($programs as $program)
            <div class="col-md-4 mb-3">
                <div class="card">
                    @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" class="card-img-top" alt="{{ $program->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $program->title }}</h5>
                        <p class="card-text">{{ Str::limit($program->description, 100) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    {{ $programs->links() }}
@else
    <p>ไม่พบหลักสูตรตามคำค้น "{{ request('keyword') }}"</p>
@endif
