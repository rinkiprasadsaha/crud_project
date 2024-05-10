
<p> Hello {{$user->name}}</p>
@component('mail::button',["url"=> url('verify/'.$user->remember_token)])
verify
@endcomponent
<p>Incase you have issue contact us</p>
{{config('app.name')}}
