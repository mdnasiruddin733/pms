@extends('backend.layout')


@section('content')
<div class="row">
    <div class="col-md-4 mb-2">
        <div class="card">
            <div class="card-body text-center">
                <h3>Customers</h3>
                <h5 class="text-muted">{{totalCustomers()}}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card">
            <div class="card-body text-center">
                <h3>Products</h3>
                <h5 class="text-muted">{{totalProducts()}}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card">
            <div class="card-body text-center">
                <h3>Orders</h3>
                <h5 class="text-muted">{{totalOrders()}}</h5>
            </div>
        </div>
    </div>
</div>
@endsection
