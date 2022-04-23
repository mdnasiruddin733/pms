<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(){
        return view('backend.pages.login');
    }
    public function dologin(request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        // dd($request->all());
        $credentials=$request->except(['_token',"remember"]);

        if (auth()->attempt($credentials,$request->remember))
        {
            return redirect(route('home'));
        }
        return redirect()->back()->with('message','invalid credentials');
    }
   
}
