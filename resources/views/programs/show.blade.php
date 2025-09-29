@extends('layouts.app')

@section('title', $program->name)

@section('content')

    <div class="container my-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" class="card-img-top" alt="{{ $program->title }}">
                    @endif
                    <div class="card-body">
                        <h1 class="card-title">{{ $program->title }}</h1>
                        <p class="card-text">{{ $program->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
