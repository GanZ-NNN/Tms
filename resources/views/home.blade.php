@extends('layouts.app')

@section('title', 'หน้าหลัก')

@section('content')

    <!-- Hero Banner -->
    @include('partials.hero-banner')

    <!-- Invest Section -->
    @include('partials.invest')

    <!-- Program Carousel -->
    @include('partials.program-carousel')

@endsection
