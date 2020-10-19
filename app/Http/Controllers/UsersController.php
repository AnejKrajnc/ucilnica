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
    public function addUser() {

    }
    public function showUser() {

    }
    public function updateUser() {

    }
    public function deleteUser() {

    }
}
