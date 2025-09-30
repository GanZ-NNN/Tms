@extends('layouts.app')

@section('title', $program->title)

@section('content')
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
                    <img src="{{ asset('images/programs/' . $program->image) }}" 
     alt="{{ $program->title }}" 
     class="img-fluid" 
     style="max-height: 400px; object-fit: cover;">

                @endif

                <div class="card-body p-4">
                    {{-- ชื่อหลักสูตร --}}
                    <h1 class="card-title mb-3 fw-bold text-primary">
                        {{ $program->title }}
                    </h1>

                    {{-- รายละเอียดหลักสูตร --}}
                    <p class="card-text text-muted fs-5">
                        {{ $program->description }}
                    </p>

                    <hr>

                    {{-- ข้อมูลเพิ่มเติม --}}
                    <div class="row mb-4">
                        <div class="col-md-6 mb-2">
                            <strong>วันเริ่มเรียน:</strong> 
                            {{ $program->start_date ? $program->start_date->format('d M Y') : 'ไม่ระบุ' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>ราคา:</strong> 
                            {{ $program->price ? number_format($program->price, 0) . ' บาท' : 'ฟรี' }}
                        </div>
                    </div>

                    {{-- ปุ่มลงทะเบียน --}}
                    <div class="d-grid mt-3">
    <a href="{{ route('programs.register', $program->id) }}" 
       class="btn btn-lg btn-success fw-bold">
        ลงทะเบียนเรียน
    </a>
</div>

                </div>
            </div>

            {{-- ปุ่มย้อนกลับ --}}
            <div class="text-center mt-4">
                <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary">
                    ← กลับไปยังรายการหลักสูตร
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
