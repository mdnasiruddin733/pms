@component('mail::message')
Hi {{$data['name']}},

<p>Your order was successfully completed.</p>
<p>Order ID.&nbsp;{{$data['order_id']}}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
