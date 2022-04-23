<?php

use App\Models\Category;
use App\Models\Generic;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

function categories(){
    return Category::latest()->get();
}
function generics(){
    return Generic::latest()->get();
}

function total(){
    $carts=session()->get('cart');
     $total=0;
    if(!is_null($carts)){
        foreach($carts as $cart){
            $total=$total+$cart['price']*$cart['quantity'];
        }
    }
   
    
    return $total;
}

function product($id){
    return Product::find($id);
}
function totalProducts(){
    return Product::count();
}
function totalCustomers(){
    return User::where("role","customer")->count();
}
function totalOrders(){
    return Order::count();
}
