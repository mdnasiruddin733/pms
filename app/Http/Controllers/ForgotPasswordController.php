<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class ForgotPasswordController extends Controller
{
    public function index(){
        return view("auth.email");
    }

    public function sendMail(Request $req){
        $this->validate($req,[
            "email"=>"required|email|exists:users,email"
        ]);
        $mail_data=[
            "name"=>User::where("email",$req->email)->first()->name,
            "url"=>URL::temporarySignedRoute("password.reset", now()->addMinutes(5))
        ];
        Mail::to($req->email)->send(new PasswordResetMail($mail_data));
        return back()->with("status","Password reset link is sent to your email");
    }

    public function resetForm(Request $request){
        if (! $request->hasValidSignature()) {
            abort(401);
        }
        return view("auth.reset");
    }

    public function reset(Request $req){
        $this->validate($req,[
            "email"=>"required|email|exists:users,email",
            "password"=>"required|min:5|confirmed"
        ]);
        $user=User::where("email",$req->email)->first();
        $user->password=bcrypt($req->password);
        $user->save();
        return redirect(route('login'));
    }
}
