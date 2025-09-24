@extends('layouts.admin')

@section('content')
    <h1 class="h2">Dashboard</h1>
    <p class="text-muted">Welcome back, {{ auth()->user()->name }} 👋</p>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Manage all system users</p>
                    <a href="#" class="btn btn-light btn-sm">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Programs</h5>
                    <p class="card-text">Manage training programs & sessions</p>
                    <a href="#" class="btn btn-light btn-sm">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Reports</h5>
                    <p class="card-text">View performance and attendance reports</p>
                    <a href="#" class="btn btn-light btn-sm">View</a>
                </div>
            </div>
        </div>
    </div>
@endsection
