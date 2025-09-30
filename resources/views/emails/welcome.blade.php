@component('mail::message')
# สวัสดี {{ $user->name }}!

ยินดีต้อนรับสู่ระบบของเรา 🎉

คุณสามารถเริ่มใช้งานบัญชีของคุณได้ทันที:

@component('mail::button', ['url' => route('dashboard')])
เข้าสู่ระบบ
@endcomponent

ขอบคุณ,<br>
ทีมงานของเรา
@endcomponent
