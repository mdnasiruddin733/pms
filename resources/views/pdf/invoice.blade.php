

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Invoice PDF</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>
	<body>
        <div class="container my-5">
            <div class="row mb-3">
                <div class="col-md-12 text-center">
                    <h3>{{config('app.name')}}</h3>
                    <p class="mb-3"><strong>Dhaka-1100, Bangladesh</strong></p>
                    <hr>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6 justify-content-left"><strong>Invoice:&nbsp;{{uniqid()}}</strong></div>
                <div class="col-6 justify-content-right"><strong>Date:&nbsp;{{date('d-m-Y')}}</strong></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 table-responsive">
                    <table class="table text-center table-stripped table-bordered">
                        <thead>
                            <tr>
                                <td>SL.</td>
                                <td>Product ID.</td>
                                <td>Product Name</td>
                                <td>Unit Price</td>
                                <td>Quantity</td>
                                <td>Amount</td>
                            </tr>
                        </thead>
                        <tbody>
                           @php $total=0; @endphp
                            @foreach ($order_details as $key=>$product)
                            @php $total=$product->quantity*$product->unit_price+$total; @endphp
                             <tr>
                                <td>{{++$key}}</td>
                                <td>{{$product->item_id}}</td>
                                <td>{{product($product->item_id)->name}}</td>
                                <td>{{$product->unit_price}}</td>
                                <td>{{$product->quantity}}</td>
                                <td>{{$product->quantity*$product->unit_price}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="5">Total Amount=</td>
                                <td>{{$total}} BDT.</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
           

        </div>
	</body>
</html>
