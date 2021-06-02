<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->post('/prikazi-vsebino', 'Courses\CourseModuleContentsController@returnContent');

//Api roeutes for dynamic adding and removing users and courses enrolled by specific user
Route::middleware(['api', 'admin'])->get('/profile', 'AdminController@profile');
Route::middleware(['api', 'admin'])->post('/add-course', 'AdminController@addCourse');
Route::middleware(['api', 'admin'])->post('/remove-course', 'AdminController@removeCourse');
Route::middleware(['api', 'admin'])->post('/change-password', 'AdminController@changePassword');
Route::middleware(['api', 'admin'])->post('/delete-user', 'AdminController@deleteUser');
