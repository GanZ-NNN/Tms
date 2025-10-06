<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            background: #fffef9;
            margin: 0;
            padding: 0;
        }
        .certificate {
            border: 12px solid #d4af37;
            padding: 40px 70px;
            width: 90%;
            max-width: 900px;
            margin: 30px auto;
            background: #fffef9;
            text-align: center;
        }
        h1 { font-size: 38px; color: #2e2e2e; margin-bottom: 8px; }
        .subtitle { font-size: 18px; color: #444; }
        .name { font-size: 32px; font-weight: bold; color: #b85c00; margin: 22px 0 12px 0; }
        .course { font-size: 22px; color: #b07a00; margin-bottom: 18px; }
        .meta { font-size: 15px; margin-top: 25px; color: #333;}
        /* Flex layout for the footer (logo, signature, QR) */
        .footer-row {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 48px;
        }
        .footer-item {
            text-align: center;
            width: 33%;
        }
        .footer-item img {
            max-width: 100px;
            height: auto;
            margin-bottom: 3px;
        }
        .signature img {
            max-width: 150px;
        }
        .footer-label {
            font-size: 13px; color: #555;
        }
    </style>
</head>
<body>
<div class="certificate">

    <h1>Certificate of Completion</h1>
    <p class="subtitle">This is to certify that</p>
    <div class="name">{{ $name ?? 'Participant Name' }}</div>
    <p class="subtitle">has successfully completed the course</p>
    <div class="course">{{ $course ?? 'Course Title' }}</div>
    <div class="meta">
        <p>Certificate ID: <strong>{{ $cert_no ?? 'CERT-XXXX' }}</strong></p>
        <p>Date Issued: <strong>{{ $date ?? now()->format('d/m/Y') }}</strong></p>
    </div>

    <div class="footer-row">
        <div class="footer-item">
            @if(!empty($qr_storage_path) && file_exists($qr_storage_path))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($qr_storage_path)) }}" alt="QR Code">
            @endif
            <div class="footer-label">QR Code</div>
        </div>
        <div class="footer-item">
            @if(!empty($logo_url) && file_exists($logo_url))
                <img src="{{ $logo_url }}" alt="Logo">
            @endif
            <div class="footer-label">Authorized Logo</div>
        </div>
        <div class="footer-item signature">
            @if(!empty($signature_image_url) && file_exists($signature_image_url))
                <img src="{{ $signature_image_url }}" alt="Signature">
            @endif
            <div class="footer-label">Instructor Signature</div>
        </div>
    </div>

</div>
</body>
</html>
