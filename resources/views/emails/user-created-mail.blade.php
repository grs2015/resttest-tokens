@component('mail::message')
# Hello {{$user->first_name}}

Thank you for create an account. Please verify your email using this button:

@component('mail::button', ['url' => $url])
Verify Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
