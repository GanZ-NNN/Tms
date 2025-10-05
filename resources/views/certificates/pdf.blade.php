<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; text-align: center; padding: 50px; }
        h1 { font-size: 32px; margin-bottom: 20px; }
        p { font-size: 18px; margin: 5px 0; }
        .qr { margin-top: 30px; }
    </style>
</head>
<body>
    <h1>Certificate of Completion</h1>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Program:</strong> {{ $session->program->title }}</p>
    <p><strong>Date:</strong> {{ $certificate->issued_at->format('d M Y') }}</p>
    <p>Signature / Logo</p>

    <div class="qr">
        {!! $qr !!}
    </div>
</body>
</html>
