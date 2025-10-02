@extends('layouts.admin')

@section('title', 'หลักสูตรทั้งหมด')

@section('content')
    @include('partials.program-carousel', ['programs' => $programs])
@endsection
