@extends('layouts.admin')

@section('content')
<h3>Certificate Details</h3>

<p><strong>Cert No:</strong> {{ $certificate->cert_no }}</p>
<p><strong>User:</strong> {{ $certificate->user->name }}</p>
<p><strong>Course:</strong> {{ $certificate->session->title }}</p>
<p><strong>Issued At:</strong> {{ $certificate->issued_at }}</p>
<p><strong>PDF:</strong> <a href="{{ Storage::url($certificate->pdf_path) }}" target="_blank">Download</a></p>

<a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary">Back</a>
@endsection
