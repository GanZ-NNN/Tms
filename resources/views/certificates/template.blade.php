<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        body { text-align: center; font-family: DejaVu Sans, sans-serif; }
        .title { font-size: 32px; font-weight: bold; margin-top: 50px; }
        .name { font-size: 28px; margin-top: 20px; }
        .course { font-size: 20px; margin-top: 15px; }
        .footer { margin-top: 60px; font-size: 14px; }
        .qr { margin-top: 40px; }
    </style>
</head>
<body>
    <div class="title">Certificate of Completion</div>
    <div class="name">{{ $user->name }}</div>
    <div class="course">ได้ผ่านการอบรม {{ $session->title }}</div>

    <div class="qr">
        <p>Scan to Verify</p>
        <img src="data:image/png;base64,{{ $qrCode }}" width="120" height="120">
    </div>

    <div class="footer">
        Certificate No: {{ $certificate->cert_no }} <br>
        Issued Date: {{ $certificate->issued_at->format('d/m/Y') }}
    </div>
</body>
</html>
