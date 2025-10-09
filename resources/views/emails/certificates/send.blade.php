@component('mail::message')
# Congratulations {{ $user->name }}!

You have successfully completed the course **{{ $certificate->session->title ?? $certificate->session->program->title }}**.

Your certificate is attached as PDF.

@component('mail::button', ['url' => route('certificates.verify.hash', $certificate->verification_hash)])
Verify Certificate
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
