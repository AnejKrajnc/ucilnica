<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\NewUser;
use App\User;
class SendMailController extends Controller
{
    protected $email;
    
    function getEmail() {
        return view('email');
    }
    function send(Request $request) {
        $user = User::find(1)->first();
        $password = "test";
        Mail::to($request->email)->send(new NewUser($user, $password));
    }
}
