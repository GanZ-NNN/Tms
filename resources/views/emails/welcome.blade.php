@component('mail::message')
# สวัสดี {{ $user->name }}!

ยินดีต้อนรับสู่ระบบของเรา 🎉

@component('mail::button', ['url' => route('home')])
ไปหน้า Dashboard
@endcomponent

ขอบคุณ,<br>
{{ config('app.name') }}
@endcomponent
