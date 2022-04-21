@extends('backend.layout')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Order List</h1>
</div>
<table class="table text-center">
  <thead>
    <tr>
      <th scope="col">SL.</th>
      <th>Order ID.</th>
      <th>TRX. ID.</th>
      <th>Payment Status</th>
      <th>Order Date</th>
      <th>Order Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach($orders as $key=>$order)
    <tr>
      <th scope="row">{{$key+1}}</th>
      <th scope="row">{{$order->id}}</th>
      <th scope="row">{{$order->tran_id}}</th>
      <th scope="row">{{$order->status}}</th>
      <th scope="row">{{$order->created_at->format('d M,Y')}}</th>
      <th scope="row"><span class="text-{{$order->order_status=="pending"? "warning":"success"}}">{{$order->order_status}}</span></th>
      <th scope="row">
          <a class="btn btn-primary" href="{{route("order.edit",$order->id)}}">
            {{$order->order_status=="pending"?"Complete Order":"Make Pending"}}
          </a>
          <a class="btn btn-danger" href="{{route('order.delete',$order->id)}}">Delete</a>
          <a href="{{route('order.details',$order->id)}}" class="btn btn-success">Details</a>
      </th>
    </tr>
  @endforeach

  </tbody>
</table>
@endsection

