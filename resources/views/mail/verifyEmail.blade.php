@component('mail::message')
# Verify Email

You are receiving this email because you created an account with us.
If you did not create the account, no further action is required.

@component('mail::button', ['url' => 'email.verify', ['email' => $user['email']], ['token' => $user['token']], false])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
