<?php

use App\Models\Category;
use App\Models\Product;
function categories(){
    return Category::latest()->get();
}

function total(){
    $carts=session()->get('cart');
    $total=0;
    foreach($carts as $cart){
        $total=$total+$cart['price']*$cart['quantity'];
    }
    return $total;
}

function product($id){
    return Product::find($id);
}
