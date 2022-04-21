<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;


class HomeController extends Controller
{
    function __construct()
    {
        $this->middleware("auth")->except(["loginForm","loginFormpost"]);
    }
    public function home(){

        if(auth()->check() && auth()->user()->role=="customer"){
            $items = Product::all();
            return view('Frontend.pages.home',compact('items'));
        }elseif(auth()->check() && auth()->user()->role=="admin"){
            return redirect("/admin/dashboard");
        }else{
            return redirect("/customer/login/form");
        }
        
    }

  
        public function registrationForm(){
            
             return view('Frontend.pages.registration'); 

        }
        public function registrationFormpost(Request $request){
            // dd($request->all());
            $request->validate([
                'name'=>'required',
                'email'=>'required',
                'password'=>'required',
            ]);
            // dd($request->all());

            return redirect()->route('home');

        }

        public function loginForm(){
            if(auth()->check()){
                return redirect(route('home'));
            }
            return view('Frontend.pages.login');
        }
        public function loginFormpost(request $request){
            //  dd($request->all());
            $request->validate([
                'email'=>'required|email',
                'password'=>'required',
            ]);
            // dd($request->all());
            $credentials=$request->except('_token');
    
            if (auth()->attempt($credentials))
            {
                return redirect()->route('home');
            }
            return redirect()->back()->with('message','invalid credentials');
        }

        public function logout(Request $req){
            auth()->logout();
            return redirect(route("login.form"));
        }

        public function myaccount(){
            return view("Frontend.pages.myaccount");
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
            $user=User::with("profile")->findOrFail(Auth::id());
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
