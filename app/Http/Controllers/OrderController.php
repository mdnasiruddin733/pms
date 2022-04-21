<?php

namespace App\Http\Controllers;

use App\Mail\OrderCompleted;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
     
    public function order(){ 
        $orders =Order::all();
        return view('backend.pages.Order.Order',compact('orders'));
    }
    
    public function orderForm(){
        return view('backend.pages.Order.createorder');
    }


    public function orderPost(Request $request){
        // dd($request->all());
        order::create([
            // coloum name of DB || name of input field
            'id'=>$request->order_id,
            
            'details'=>$request->order_details,
        ]);

        return redirect()->route('admin.order.show');
    }

    public function orderDetails($id){
        $order=Order::findOrFail($id);
        return view("backend.pages.Order.details",compact('order'));
    }

    public function editOrder($id){
         $order=Order::findOrFail($id);
         if($order->order_status=="pending"){
             $order->order_status="complete";
             $mail_data=[
                 "name"=>$order->user->name,
                 "order_id"=>$order->id
             ];
             Mail::to($order->user->email)->send(new OrderCompleted($mail_data));
         }else{
             $order->order_status="pending";
         }
         $order->save();
         return back();
        
    }

    public function deleteOrder($id){
         $order=Order::findOrFail($id);
         $order->delete();
         return back();
        
    }
}
