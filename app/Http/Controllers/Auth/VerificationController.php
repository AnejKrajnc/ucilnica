<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;

class VerificationController extends Controller
{

    public function potrdiNastaviGesloStran(Request $request) {

        $user = User::where('registration_token', $request->registration_token)->first();

        if ($user != null)
            return view('auth\verify');
        else
            return view('auth\wrong-verify');
    }

    public function potrdiNastaviGeslo(Request $request) {
        $user = User::where('registration_token', $request->registration_token)->first();

        $data = $request->all();

        if ($user != null) {
            if(!($data['password'] == $data['confirm-password'])) return redirect()->back()->with('message', 'Gesli se ne ujemata!');
            $user->password = Hash::make($data['password']);
            $user->registration_token = null; // setting registration to NULL alias as user is already registered
            $user->save();
            return view('auth\verify-success');
        }
        else
            return view('auth\wrong-verify');
    }
}
