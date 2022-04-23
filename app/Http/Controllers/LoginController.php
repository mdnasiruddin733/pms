<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    function __construct()
    {
        $this->middleware("guest")->except("logout");
    }
    
   public function index(){
       return view("auth.login");
   }

   public function login(Request $req){
       
       $req->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        // dd($request->all());
        $credentials=$req->except(['_token',"remember"]);

        if (auth()->attempt($credentials,$req->remember))
        {
           return $this->redirectTo();
        }
        return redirect()->back()->with('message','invalid credentials');
   }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login')->with('message','Logout Successful');
    }

    private function redirectTo(){
        if(auth()->check() && auth()->user()->role==="admin"){
            return redirect(route("admin.dashboard"));
        }elseif(auth()->check() && auth()->user()->role==="customer"){
             return redirect(route("customer.dashboard"));
        }
    }
}
