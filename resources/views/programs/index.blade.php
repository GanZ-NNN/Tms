@extends('layouts.app')

@section('title', 'รายการโปรแกรม')

@section('content')
<div class="container my-5">
    
    {{-- แสดง success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($programs as $program)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">

                    {{-- รูปโปรแกรม --}}
                    @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" 
                             class="card-img-top" 
                             alt="{{ $program->title }}" 
                             style="height:200px; object-fit:cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $program->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($program->description, 100) }}</p>

                        {{-- ปุ่มดูรายละเอียด --}}
                        <a href="{{ route('programs.show', $program->id) }}" 
                           class="btn btn-primary mt-auto mb-2">
                            ดูรายละเอียด
                        </a>

                        {{-- ปุ่มลงทะเบียน (ถ้า login) --}}
                        @auth
                            <a href="{{ route('programs.register', $program->id) }}" 
                               class="btn btn-success mt-1">
                                ลงทะเบียนเรียน
                            </a>
                        @else
                            {{-- ถ้ายังไม่ login --}}
                            <a href="{{ route('login') }}?redirect={{ route('programs.show', $program->id) }}" 
                               class="btn btn-outline-success mt-1">
                                ลงทะเบียน (ต้อง login)
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted fs-5">ยังไม่มีโปรแกรมใด ๆ ในขณะนี้</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
