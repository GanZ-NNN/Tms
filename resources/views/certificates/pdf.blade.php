<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Certificate of Completion</title>
<style>
    body {
        font-family: 'Times New Roman', serif;
        background: linear-gradient(to right, #fff8ec, #fff4d4);
        margin: 0;
        padding: 0;
    }
    .certificate {
        border: 15px solid #d4af37;
        padding: 40px 70px;
        margin: 20px auto;
        width: 90%;
        height: 700px;
        background-color: #fffef9;
        box-shadow: 0 0 15px rgba(0,0,0,0.15);
        position: relative;
        text-align: center;
    }

    h1 { font-size: 40px; margin-top: 20px; color: #2e2e2e; }
    p { font-size: 18px; color: #444; }

    .name { font-size: 36px; font-weight: bold; color: #b85c00; margin: 25px 0; }
    .course { font-size: 24px; color: #b07a00; margin-bottom: 10px; }

    .meta { font-size: 16px; margin-top: 30px; }

    .logo {
        position: absolute;
        left: 60px;
        bottom: 60px;
        text-align: center;
    }
    .logo img { width: 100px; height: auto; }

    .signature {
        position: absolute;
        right: 100px;
        bottom: 50px;
        text-align: center;
    }
    .signature img { width: 160px; height: auto; }

    .qr {
        position: absolute;
        left: 60px;
        top: 60px;
    }
    .qr img { width: 100px; height: 100px; }
</style>
</head>
<body>
<div class="certificate">

    {{-- QR Code --}}
    @if(!empty($qr_storage_path) && file_exists($qr_storage_path))
        <div class="qr">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($qr_storage_path)) }}" alt="QR Code">
        </div>
    @endif

    <h1>Certificate of Completion</h1>
    <p>This is to certify that</p>
    <div class="name">{{ $name ?? 'Participant Name' }}</div>
    <p>has successfully completed the course</p>
    <div class="course">{{ $course ?? 'Course Title' }}</div>

    <div class="meta">
        <p>Certificate ID: <strong>{{ $cert_no ?? 'CERT-XXXX' }}</strong></p>
        <p>Date Issued: <strong>{{ $date ?? now()->format('d/m/Y') }}</strong></p>
    </div>

    <div class="logo">
        @if(!empty($logo_url) && file_exists($logo_url))
            <img src="{{ $logo_url }}" alt="Logo">
        @endif
        <div>Authorized Logo</div>
    </div>

    <div class="signature">
        @if(!empty($signature_image_url) && file_exists($signature_image_url))
            <img src="{{ $signature_image_url }}" alt="Signature">
        @endif
        <div>Instructor Signature</div>
    </div>
</div>
</body>
</html>
