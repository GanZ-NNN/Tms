<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate of Completion</title>
    <style>
  
        /* --- Global Styles --- */
        @page {
            margin: 0; /* ลบ margin ของหน้ากระดาษ */
        }
        body { 
            font-family: 'DejaVu Sans', 'THSarabunNew', sans-serif;
            margin: 0; 
            padding: 0;
            font-size: 16px;
        }

        /* --- Layout Styles (ส่วนที่แก้ไข) --- */
        .page-container {
            width: 297mm;  /* A4 Landscape width */
            height: 210mm; /* A4 Landscape height */
            position: relative;
        }
        .page-border {
            border: 5mm solid #c9a96a;
            position: absolute;
            top: 10mm;
            left: 10mm;
            right: 10mm;
            bottom: 10mm;
        }
        .content-wrapper {
            position: absolute;
            top: 15mm;
            left: 15mm;
            right: 15mm;
            bottom: 15mm;
            text-align: center;
        }
        
        /* --- Content Styles --- */
        h1 { font-size: 42px; font-weight: bold; color: #b8860b; margin: 20px 0 40px 0; letter-spacing: 4px;}
        p { font-size: 20px; color: #333; margin: 5px 0; }
        .user-name { font-size: 38px; font-weight: bold; color: #000; margin: 40px 0; border-bottom: 2px solid #555; display: inline-block; padding-bottom: 5px;}
        .course-name { font-size: 30px; font-weight: bold; color: #b8860b; margin: 40px 0; }
        .details { font-size: 16px; color: #555; margin-top: 50px; }
        
        /* --- Footer Styles --- */
        .footer {
            position: absolute;
            bottom: 25mm;
            left: 25mm;
            right: 25mm;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-table td {
            width: 50%;
            vertical-align: bottom;
        }
        .qr-code { text-align: left; font-size: 14px; }
        .dean-signature { text-align: right; font-size: 16px; }
        .signature-line { border-top: 1px solid #555; margin-top: 50px; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="page-container">
        {{-- กรอบจะถูกวาดก่อน --}}
        <div class="page-border"></div>

        {{-- เนื้อหาทั้งหมดจะอยู่ใน wrapper นี้ --}}
        <div class="content-wrapper">
            {{-- ส่วนเนื้อหาตรงกลาง --}}
            <div>
                <h1>CERTIFICATE OF COMPLETION</h1>
                <p>This is proudly presented to</p>
                <div class="user-name">{{ $user->name }}</div>
                <p>for successfully completing the course</p>
                <div class="course-name">{{ $session->program->title }}</div>
                <p class="details">
                    Certificate ID: {{ $cert_no }} | Date Issued: {{ $issued_at->format('F d, Y') }}
                </p>
            </div>

            {{-- ส่วนท้าย (Footer) --}}
            <div class="footer">
                <table class="footer-table">
                    <tr>
                        <td class="qr-code">
                            <strong>QR Code</strong><br>
                            <span>Verification Link</span><br>
                            <img src="data:image/png;base64, {{ $qrCodeBase64 }} ">
                        </td>
                        <td class="dean-signature">
                            <img src="{{ public_path('assets/img/KKU_SLA_Logo.svg.png') }}" alt="KKU Logo" style="width: 150px; margin-bottom: 10px;">
                            <div class="signature-line">
                                <strong>Assoc. Prof. Rachapon Santiwarakorn, Ph.D.</strong><br>
                                <span>Dean, Faculty of Engineering</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>