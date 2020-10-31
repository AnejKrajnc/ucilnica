<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function showUsers() {
        $users = User::all();
        return view('admin.users')->withUsers($users);
    }
    public function addUser(Request $request) {
        $password = Str::random(8);
        $input = $request->all();
        $newUser = User::create([
            'name' => $input['ime'],
            'email' => $input['uporabnisko'],
            'avatar' => 'users/default-png',
            'usertype' => 'student',
            'password' => Hash::make(),
            'created_at' => NOW($password),
            'updated_at' => NOW()
        ]);
        return 'uporabnisko ime: '.$input['uporabnisko'].' geslo: '.$password.' ['.$input['ime'].']';
    }
    public function NewUser() {
        return view('admin.newuser');
    }
    public function showUser() {

    }
    public function updateUser() {

    }
    public function deleteUser() {

    }
}
