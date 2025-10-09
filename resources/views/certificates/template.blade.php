<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
    @page {
        size: 8.5in 11in;
        margin: 0;
    }
    body {
        margin: 0;
        padding: 0;
        font-family: 'Times New Roman', serif;
        background-color: #fffef9;
    }
    .certificate-container {
        width: 8.5in;
        height: 11in;
        border: 12px solid #D4AF37;
        padding: 30px 50px;
        box-sizing: border-box;
        text-align: center;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        page-break-inside: avoid;
        page-break-after: avoid;
    }
    .main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-top: -40px;
    }
    .title {
        color: #D4AF37;
        font-size: 48px;
        font-weight: bold;
        letter-spacing: 6px;
        margin-bottom: 0;
        line-height: 1;
    }
    .subtitle {
        color: #444;
        font-size: 28px;
        margin-top: 5px;
        line-height: 1;
    }
    .presented-text {
        font-size: 16px;
        margin: 35px 0 15px 0;
    }
    .recipient {
        font-size: 34px;
        font-weight: bold;
        text-transform: uppercase;
        border-bottom: 2px solid #444;
        display: inline-block;
        padding: 5px 30px;
        margin: 0;
    }
    .completion-text {
        font-size: 16px;
        margin: 25px 0 12px 0;
    }
    .course {
        font-size: 20px;
        font-style: italic;
        margin: 0;
        line-height: 1.3;
    }
    .offered-by {
        font-size: 13px;
        color: #555;
        margin: 18px 0;
    }
    .meta-info {
        font-size: 12px;
        color: #555;
        margin: 15px 0 0 0;
    }
    .footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        width: 100%;
        padding-top: 20px;
    }
    .footer-item {
        width: 30%;
        text-align: center;
    }
    .footer-item img {
        display: block;
        margin: 0 auto 8px;
    }
    .footer-item small {
        display: block;
        color: #666;
        font-size: 11px;
        line-height: 1.3;
    }
    .signature-line {
        width: 160px;
        height: 1px;
        background-color: #333;
        margin: 5px auto 3px;
    }
    .verify-text {
        font-size: 9px;
        color: #777;
        margin-top: 2px;
    }
    .dean-name {
        font-size: 13px;
        font-weight: bold;
        margin: 3px 0 2px 0;
    }
</style>
</head>
<body>
    <div class="certificate-container">
        <div class="main-content">
            <!-- Title -->
            <div>
                <div class="title">CERTIFICATE</div>
                <div class="subtitle">OF COMPLETION</div>
            </div>

            <!-- Recipient -->
            <p class="presented-text">This is proudly presented to</p>
            <div class="recipient">{{ strtoupper($user->name) }}</div>

            <!-- Course Info -->
            <p class="completion-text">for successfully completing the course</p>
            <div class="course">
                {{ strtoupper(optional($session->program)->title ?? $session->title) }}
            </div>

            <p class="offered-by">
                Offered by Faculty of Engineering, Khon Kaen University
            </p>

            <!-- Metadata -->
            <div class="meta-info">
                Certificate ID: <strong>{{ $certificate->cert_no }}</strong> |
                Date Issued: <strong>{{ $certificate->issued_at->format('F d, Y') }}</strong>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <!-- QR Code -->
            <div class="footer-item">
                @if(!empty($qrCodeBase64))
                    <img src="data:image/png;base64,{{ $qrCodeBase64 }}" width="90" height="90" alt="QR Code">
                @endif
                <small>Verification QR Code</small>
                <small class="verify-text">Scan to verify authenticity</small>
            </div>

            <!-- Authorized Logo -->
            <div class="footer-item">
                @if(!empty($logoBase64))
                    <img src="data:image/png;base64,{{ $logoBase64 }}" width="70" height="70" alt="Authorized Logo">
                @endif
                <small>Authorized Logo/Seal</small>
            </div>

            <!-- Signature -->
            <div class="footer-item">
                @if(!empty($signatureBase64))
                    <img src="data:image/png;base64,{{ $signatureBase64 }}" width="120" height="50" alt="Signature">
                @endif
                <div class="signature-line"></div>
                <div class="dean-name">Assoc. Prof. Ratchaphon Suntivarakorn, Ph.D.</div>
                <small>Dean, Faculty of Engineering</small>
            </div>
        </div>
    </div>
</body>
</html>
