@component('mail::message')
# Hi, {{$data['name']}}

Please, you can reset your password clicking this link below.

@component('mail::button', ['url' => $data['url']])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
