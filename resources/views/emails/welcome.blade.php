@component('mail::message')
# Welcome, {{ $user->name }}

Thank you for registering with us!

@component('mail::button', ["url"=> url('verify/')])
Visit Our Site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
