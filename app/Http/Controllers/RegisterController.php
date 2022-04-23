<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    function __construct()
    {
         $this->middleware("guest");
    }
    public function index(){
        return view("auth.register");
    }

    public function register(Request $req){
        $this->validate($req,[
            "name"=>"required|string|max:25",
            "email"=>"required|email",
            "password"=>"required|min:5|confirmed"
        ]);
        
        $user=User::create([
            "name"=>$req->name,
            "email"=>$req->email,
            "password"=>bcrypt($req->password),
            "role"=>"customer"
        ]);
        return redirect(route("login"));

    }
}
