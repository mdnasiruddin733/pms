@extends('Frontend.master')

@section('content')

    <div class="row" >
        <div class="col-md-1"></div>
        <div class="col-md-4 order-md-2 mb-4" style="margin-top: 100px;">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">{{session()->has('cart')?count(session()->get('cart')):0}}</span>
            </h4>
            <ul class="list-group mb-3">
                @if(session()->has('cart'))
                    @foreach(session()->get('cart') as $key=>$cartData)
                        <tr>
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <h4 class="nomargin">{{$cartData['name']}}</h4>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">{{$cartData['price']*$cartData['quantity']}} .BDT</td>

                           
                            <td class="actions" data-th="">
                                <a href="{{route('cart.delete',$key)}}"  style="color: white" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td>
                            <h1>Your Cart is Empty.</h1>
                        </td>
                    </tr>


                @endif
            </ul>


        </div>
        <div class="col-md-6 order-md-1" style="margin-top: 100px;">
            <h4 class="mb-3">Billing address</h4>
            <form action="{{ route('pay') }}" method="post" class="needs-validation" novalidate="">
                @csrf

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="firstName">Name</label>
                        <input name="name" type="text" class="form-control" id="firstName" placeholder="" value="{{auth()->user()->name}}" required="">
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">Email <span class="text-muted">(Optional)</span></label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="you@example.com" value="{{auth()->user()->email}}">
                    <div class="invalid-feedback">
                        Please enter a valid email address for shipping updates.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address">Address</label>
                    <input name="address" type="text" class="form-control" id="address" placeholder="1234 Main St" required="" value="{{auth()->user()->profile->address}}">
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                </div>




                <hr class="mb-4">

                <h4 class="mb-3">Payment</h4>

                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                        <label class="custom-control-label" for="credit">Cash On Delivery (COD)</label>
                    </div>

                </div>


                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>

            </form>
        </div>
    </div>
@endsection