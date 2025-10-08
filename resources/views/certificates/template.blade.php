<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        @page { margin: 0px; }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', serif;
            background-color: #fffef9;
        }
        .certificate-container {
            width: 100%;
            height: 100%;
            border: 12px solid #D4AF37; /* gold border */
            padding: 60px;
            box-sizing: border-box;
            text-align: center;
        }
        .title {
            color: #D4AF37;
            font-size: 60px;
            font-weight: bold;
            letter-spacing: 8px;
        }
        .subtitle {
            color: #444;
            font-size: 36px;
            font-weight: 400;
            margin-top: -10px;
        }
        .recipient {
            font-size: 44px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #444;
            display: inline-block;
            margin-top: 25px;
            padding: 5px 20px;
        }
        .course {
            font-size: 26px;
            font-style: italic;
            margin-top: 20px;
        }
        .meta {
            margin-top: 50px;
            font-size: 14px;
            color: #555;
        }
        .footer {
            margin-top: 80px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
        }
        .footer-item {
            width: 30%;
            text-align: center;
        }
        .footer-item img {
            display: block;
            margin: 0 auto;
        }
        .footer-item small {
            display: block;
            color: #666;
        }
        .signature-line {
            width: 160px;
            height: 1px;
            background-color: #333;
            margin: 6px auto 4px;
        }
        .verify-text {
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Title -->
        <div>
            <div class="title">CERTIFICATE</div>
            <div class="subtitle">OF COMPLETION</div>
        </div>

        <!-- Recipient -->
        <p style="font-size:18px; margin-top:40px;">This is proudly presented to</p>
        <div class="recipient">{{ strtoupper($user->name) }}</div>

        <!-- Course Info -->
        <p style="font-size:18px; margin-top:30px;">for successfully completing the course</p>
        <div class="course">
            {{ strtoupper($session->program->title ?? $session->title) }}
        </div>
        <p class="meta">
            Offered by Faculty of Engineering, Khon Kaen University
        </p>

        <!-- Metadata -->
        <div class="meta">
            <p>
                Certificate ID:
                <strong>{{ $certificate->cert_no }}</strong> |
                Date Issued:
                <strong>{{ $certificate->issued_at->format('F d, Y') }}</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <!-- QR Code -->
            <div class="footer-item">
                @if(isset($qrCodePath))
                    <img src="{{ $qrCodePath }}" alt="QR Code">
                @endif
                <small>Verification QR Code</small>
                <small class="verify-text">Scan to verify authenticity</small>
            </div>

            <!-- Authorized Logo -->
            <div class="footer-item">
                <img src="{{ public_path('images/logo.png') }}" width="80" height="80" alt="Authorized Logo">
                <small>Authorized Logo/Seal</small>
            </div>

            <!-- Signature -->
            <div class="footer-item">
                <img src="{{ public_path('images/signature.png') }}" width="120" height="60" alt="Signature">
                <div class="signature-line"></div>
                <div style="font-size:14px; font-weight:bold;">Assoc. Prof. Ratchaphon Suntivarakorn, Ph.D.</div>
                <small>Dean, Faculty of Engineering</small>
            </div>
        </div>
    </div>
</body>
</html>
