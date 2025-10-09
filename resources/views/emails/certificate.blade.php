@component('mail::message')
# Congratulations {{ $certificate->user->name }}!

You have successfully completed the course:

**{{ optional($certificate->session->program)->title ?? $certificate->session->title }}**

Please find your certificate attached.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
