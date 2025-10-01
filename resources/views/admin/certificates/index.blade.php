@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Certificates</h3>
    <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">+ Generate Certificate</a>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Cert No</th>
            <th>User</th>
            <th>Course</th>
            <th>Issued At</th>
            <th>Download</th>
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
        </tr>
        @endforeach
    </tbody>
</table>

{{ $certificates->links() }}
@endsection
