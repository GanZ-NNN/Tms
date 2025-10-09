@component('mail::message')
# Congratulations {{ $certificate->user->name }}!

You have successfully completed the training session: **{{ $certificate->session->title }}**.

Your certificate (ID: {{ $certificate->cert_no }}) is attached as a PDF.

You can also verify your certificate by scanning the QR code or visiting:
[Verify Certificate]({{ route('certificates.verify.hash', $certificate->verification_hash) }})

Thanks,<br>
{{ config('app.name') }}
@endcomponent
