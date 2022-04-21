@extends('Frontend.master')

@section('content')
<div class="row">
    <form action="{{route('myaccount.update')}}" method="post" class="col-md-12">
        @csrf
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3>My Account</h3>
                </div>
                <div class="card-body">
                     <div class="row mb-2">
                        <div class="col-4"><strong>Name:</strong></div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Email:</strong></div>
                        <div class="col-6">
                            <input type="email" class="form-control" name="email" value="{{auth()->user()->email}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Phone:</strong></div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="phone" value="{{auth()->user()->profile->phone}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h3>Shipping Address</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-4"><strong>Country:</strong></div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="country" value="{{auth()->user()->profile->country}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>City:</strong></div>
                        <div class="col-6">
                        <input type="text" class="form-control" name="city" value="{{auth()->user()->profile->city}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Postcode:</strong></div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="postcode" value="{{auth()->user()->profile->postcode}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><strong>Address:</strong></div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="address" value="{{auth()->user()->profile->address}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <input type="submit" value="Update Profile" class="btn btn-success">             
        </div>
    </form>  
</div>

@endsection