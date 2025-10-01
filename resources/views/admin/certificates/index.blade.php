@extends('layouts.admin')

@section('content')
<h3>Certificates</h3>
<div class="mb-3">
    <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">+ Generate Certificate</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Cert No</th>
            <th>User</th>
            <th>Course</th>
            <th>Issued At</th>
            <th>Download</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($certificates as $cert)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $cert->cert_no }}</td>
            <td>{{ $cert->user->name }}</td>
            <td>{{ $cert->session->title }}</td>
            <td>{{ $cert->issued_at }}</td>
            <td>
                <a href="{{ Storage::url($cert->pdf_path) }}" target="_blank" class="btn btn-sm btn-success">Download</a>
            </td>
            <td>
                <form action="{{ route('admin.certificates.destroy', $cert) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $certificates->links() }}
@endsection
