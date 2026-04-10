{{-- blade-formatter-disable --}}
@component('mail::message')
# Email Verification Code

Hello {{ $userName }},

Please use the following 4-digit code to verify your email address:

@component('mail::panel')
<div style="text-align: center; font-size: 32px; font-weight: bold; letter-spacing: 8px;">{{ $code }}</div>
@endcomponent

This code will expire in **10 minutes**.

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
{{-- blade-formatter-disable --}}