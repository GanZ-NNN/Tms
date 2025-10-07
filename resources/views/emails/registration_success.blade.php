<h2>ยืนยันการลงทะเบียนสำเร็จ</h2>
<p>สวัสดี {{ $user->name }},</p>
<p>คุณได้ลงทะเบียนในรอบอบรม <strong>{{ $session->title }}</strong></p>
<p>วันที่: {{ $session->start_at->format('d M Y') }} - {{ $session->end_at->format('d M Y') }}</p>
<p>สถานที่: {{ $session->location ?? 'ออนไลน์' }}</p>
<p>ขอบคุณที่เข้าร่วมกับเรา!</p>
