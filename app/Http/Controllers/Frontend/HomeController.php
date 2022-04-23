<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;


class HomeController extends Controller
{

        public function welcome(){
            $items=Product::latest()->get();
            return view("Frontend.pages.home",compact('items'));
        }
        
        public function myaccount(){
            return view("Frontend.pages.myaccount");
        }

        public function customerDashboard(){
            $items=Product::latest()->get();
            return view("Frontend.pages.home",compact('items'));
        }

        public function adminDashboard(){

            return view("Backend.pages.dashboard");
        }
        public function updateAccount(Request $req){
            $this->validate($req,[
                "name"=>"required",
                "email"=>"required|email",
                "phone"=>"nullable|string|max:15",
                "country"=>"nullable|string|max:20",
                "city"=>"nullable|string|max:20",
                "postcode"=>"nullable|string|max:20",
                "address"=>"nullable|string|max:100"
            ]);
            $user=User::with("profile")->findOrFail(auth()->user()->id);
            $user->name=$req->name;
            $user->email=$req->email;
            $user->save();
            $user->profile->update([
                "country"=>$req->country,
                "city"=>$req->city,
                "postcode"=>$req->postcode,
                "address"=>$req->address,
                "phone"=>$req->phone
            ]);
            return back();
        }


        public function myorders(){
            return view("frontend.pages.myorders");
        }
        public function orderDetails($id){
            $order=Order::findOrFail($id);
            return view("Frontend.pages.order-details",compact('order'));
        }

}
