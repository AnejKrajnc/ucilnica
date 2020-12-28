<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Course;
use App\CourseEnrolled;

class UsersController extends Controller
{
    public function showUsers() {
        $users = User::all();
        return view('admin.users')->withUsers($users);
    }
    public function addUser(Request $request) {
        $input = $request->all();
        $password = str_replace(' ', '', strtolower($input['ime']));
        $password .= rand(1, 999);
        $newUser = User::create([
            'name' => $input['ime'],
            'email' => $input['uporabnisko'],
            'avatar' => 'users/default-png',
            'usertype' => 'student',
            'password' => Hash::make($password),
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);
        foreach ($input['tecaji'] as $tecaj) {
            CourseEnrolled::create([
                'user_id' => $newUser->id,
                'course_id' => $tecaj,
                'enrolled_in' => NOW(),
                'progress' => 0.00
            ]);
        }
        return view('admin.added-user')->withUsername($input['uporabnisko'])->withPassword($password)->withName($input['ime']);
    }
    public function NewUser() {
        $tecaji = Course::all();
        return view('admin.newuser')->withTecaji($tecaji);
    }
    public function showUser() {

    }
    public function updateUser() {

    }
    public function deleteUser() {

    }
}
