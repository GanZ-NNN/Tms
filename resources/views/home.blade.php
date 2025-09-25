@extends('layouts.app')

@section('title', 'หน้าหลัก')

@section('content')
    <h2>หลักสูตรทั้งหมด</h2>
    <div class="row">
        @foreach($programs as $program)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>{{ $program->title }}</h5>
                        <p>{{ $program->description }}</p>
                        <a href="#" class="btn btn-primary">ดูรายละเอียด</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
