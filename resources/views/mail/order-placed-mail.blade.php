@component('mail::message')
# Hi, {{$data['name']}},

<p>Your order is place successfully.</p>
<p>Transaction ID:{{$data['tran_id']}}</p>

@component('mail::button', ['url' => $data["url"]])
Track Your Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
