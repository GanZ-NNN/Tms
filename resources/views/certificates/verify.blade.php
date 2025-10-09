<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f7f7f7; }
        .box { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); display: inline-block; }
        h1 { margin-bottom: 20px; }
        .valid { color: green; font-size: 18px; }
        .invalid { color: red; font-size: 18px; }
        .meta { margin-top: 15px; font-size: 14px; color: #555; }
    </style>
</head>
<body>
    <div class="box">
        @if($valid)
            <h1>✅ Certificate is VALID</h1>
            <p class="valid">This certificate has been issued by Faculty of Engineering, Khon Kaen University.</p>
            <div class="meta">
                <p>Certificate ID: <strong>{{ $certificate->cert_no }}</strong></p>
                <p>Issued to: <strong>{{ $certificate->user->name }}</strong></p>
                <p>Course: <strong>{{ $certificate->session->program->title ?? $certificate->session->title }}</strong></p>
                <p>Date Issued: <strong>{{ $certificate->issued_at->format('F d, Y') }}</strong></p>
            </div>
        @else
            <h1>❌ Certificate is INVALID</h1>
            <p class="invalid">No valid certificate found with this verification link.</p>
        @endif
    </div>
</body>
</html>
