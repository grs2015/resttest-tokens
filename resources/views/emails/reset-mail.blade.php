@component('mail::message')
# Hello!

Please click the button to reset your password!

@component('mail::button', ['url' => $url])
Password Reset
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
