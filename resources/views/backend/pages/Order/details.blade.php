@extends('backend.layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Order Details</h1>
</div>
<div class="card">
  <div class="card-body">
    <p><strong>Order ID:&nbsp;</strong>{{$order->id}}</p>
    <p><strong>Transaction ID:&nbsp;</strong>{{$order->tran_id}}</p>
  </div>
</div>
<table class="table text-center">
  <thead>
    <tr>
      <th scope="col">SL.</th>
      <th>Item ID.</th>
      <th>Item Name.</th>
      <th>Quantity.</th>
      <th>Unit Price</th>
      <th>Amount</th>
    </tr>
  </thead>
  <tbody>
  @php $total=0; @endphp
  @foreach($order->details as $key=>$item)
  @php $total=$total+$item->quantity*$item->unit_price; @endphp
    <tr>
      <th scope="row">{{$key+1}}</th>
      <th scope="row">{{$item->item_id}}</th>
      <th scope="row">{{product($item->item_id)->name}}</th>
      <th scope="row">{{$item->quantity}}</th>
      <th scope="row">{{$item->unit_price}}</th>
      <th scope="row">{{$item->quantity*$item->unit_price}}</th>
    </tr>
  @endforeach
  <tr>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th>Total Amount=</th>
    <th>{{$total}}BDT</th>
  </tr>

  </tbody>
</table>
@endsection

