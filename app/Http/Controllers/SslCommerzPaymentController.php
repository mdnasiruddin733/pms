<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;

class SslCommerzPaymentController extends Controller
{

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = total(); # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->name;
        $post_data['cus_email'] = $request->email;
        $post_data['cus_add1'] = $request->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = auth()->user()->profile->city;
        $post_data['cus_state'] = auth()->user()->profile->city;
        $post_data['cus_postcode'] =auth()->user()->profile->postcode;
        $post_data['cus_country'] = auth()->user()->profile->country;
        $post_data['cus_phone'] = auth()->user()->profile->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $request->name;
        $post_data['ship_add1'] = $request->address;
        $post_data['ship_add2'] = $request->address;
        $post_data['ship_city'] = auth()->user()->profile->city;
        $post_data['ship_state'] = auth()->user()->profile->city;
        $post_data['ship_postcode'] =auth()->user()->profile->postcode;
        $post_data['ship_phone'] = auth()->user()->profile->phone;
        $post_data['ship_country'] = auth()->user()->profile->country;

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Life Style";
        $post_data['product_category'] = "Fashion";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $order=Order::create([
//           'user_id' =>auth()->user()->id,
            'user_id' =>auth()->user()->id,
            'status' =>'pending',
            'tran_id' => $post_data['tran_id'],
            'receiver_name' =>$request->name,
            'receiver_email' =>$request->email,
            'receiver_address' =>$request->address,
            "payment_method"=>"Online",
            'total' =>total(),
        ]);

        // step 2 insert product into order details
        foreach(session()->get('cart') as $product_id=>$cartData)
        {
            OrderDetails::create([
                'order_id'=>$order->id,
                'item_id'=>$product_id,
                'quantity'=>$cartData['quantity'],
                'unit_price'=>$cartData['price'],
                'subtotal'=>$cartData['subtotal'],
            ]);

            //stock update here
            $product=Product::find($product_id);
            $product->decrement('quantity',$cartData['quantity']);

        }
        session()->forget('cart');
        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request){
        
        session()->forget('cart');
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $sslc = new SslCommerzNotification();
     

        #Check order status in order tabel against the transaction id or order id.
       $order_details=Order::where('tran_id',$tran_id)->first();

        if ($order_details->status == 'pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $order_details->update([
                   'status'=>'success'
               ]);

            //    Mail sending 

            $mail_data=[
                "name"=>auth()->user()->name,
                "email"=>auth()->user()->email,
                "tran_id"=> $order_details->tran_id,
                "url"=>route("my-order.details",$order_details->id)
            ];

            
            Mail::to(auth()->user()->email)->send(new OrderPlacedMail($mail_data, $order_details));



            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $order_details->update([
                    'status'=>'failed'
                ]);

            }
        }

        return redirect(route('home'));
    }



    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details=Order::where('tran_id',$tran_id)->first();
        if ($order_details->status == 'pending') {
            $order_details->update([
                'status'=>'failed'
            ]);
        }

        return redirect()->route('home');

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details=Order::where('tran_id',$tran_id)->first();
        if ($order_details->status == 'pending') {
            $order_details->update([
                'status'=>'cancel'
            ]);
        }

        return redirect()->route('home');


    }


     public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }


}
