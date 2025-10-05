<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .certificate {
            width: 800px;
            height: 600px;
            padding: 50px;
            border: 10px solid #2c3e50;
            background: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
            position: relative;
        }

        .certificate h1 {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .certificate h2 {
            font-size: 28px;
            color: #34495e;
            margin: 20px 0;
        }

        .certificate p {
            font-size: 18px;
            margin: 10px 0;
            color: #555;
        }

        .certificate .highlight {
            font-weight: bold;
            color: #e74c3c;
        }

        .certificate .footer {
            position: absolute;
            bottom: 50px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 50px;
            font-size: 16px;
            color: #777;
        }

        .certificate .qr {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Certificate of Completion</h1>
        <p>This is to certify that</p>
        <h2 class="highlight">{{ $user->name }}</h2>
        <p>has successfully completed the program</p>
        <h2 class="highlight">{{ $session->program->title }}</h2>
        <p>Certificate No: <span class="highlight">{{ $cert_no }}</span></p>
        <p>Date: <span class="highlight">{{ $issued_at->format('d M Y') }}</span></p>

        <div class="qr">
            {!! $qr !!}
        </div>

        <div class="footer">
            <div>Signature</div>
            <div>Logo</div>
        </div>
    </div>
</body>
</html>
