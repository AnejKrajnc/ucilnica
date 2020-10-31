<?php

use Illuminate\Support\Facades\Route;
use App\Course;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->middleware('auth');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/moj-profil', 'HomeController@myprofile')->name('moj-profil');
Route::post('/moj-profil', 'HomeController@changemyprofile');
/* Routes for Tečaji */
Route::group(['middleware' => ['auth', 'student']], function () {
    Route::get('/tecaji/{tecaj}', 'HomeController@tecaji');
    Route::get('/tecaji/{tecaj}/{datoteka}', 'FileStorageController@prenesi');
});

Route::get('/tecaji', 'HomeController@index');

/* Routes for Payments (Nakupi spletnih tečajev) */
Route::get('/nakup', 'PaymentController@index');
Route::post('/nakup', 'PaymentController@orderStepOne');
Route::post('/nakup/{token}', 'PaymentController@orderProcess');
Route::get('/nakup/{token}', 'PaymentController@orderProcess');
Route::get('/nakup/{token}/paypal', 'Payment\PaypalController@prepare');
/* Route to show Bill in PDF format */
Route::get('/nakup/racuni/{id}', 'PDFController@showBill');
/* Routes for Admin with dashboard */
Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', 'AdminController@showDashboard');
    /**
     * Routes for Courses Management by CoursesController
     */
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/courses', 'Courses\CoursesController@showCourses');
        Route::post('/courses', 'Courses\CoursesController@addCourse');
        Route::get('/courses/{id}', 'Courses\CoursesController@showCourse');
        Route::post('/courses/{id}', 'Courses\CoursesController@updateCourse');
        Route::delete('/courses/{id}', 'Courses\CoursesController@deleteCourse');
    });
    /**
     * Routes for Course Modules Management by CourseModulesController
     */
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/courses/{id}/modules', 'Courses\ModulesController@showModules');
        Route::post('/courses/{id}/modules', 'Courses\ModulesController@addModule');
        Route::get('/courses/{id}/modules/{idmod}', 'Courses\ModulesController@showModule');
        Route::post('/courses/{id}/modules/{idmod}', 'Courses\ModulesController@updateModule');
        Route::delete('/courses/{id}/modules/{idmod}', 'Courses\ModulesController@deleteModule');
    });
    /**
     * Routes for Course Module Contents Management by CourseModuleContentsController
     */
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/courses/{id}/modules/{idmod}/contents', 'Courses\CourseModuleContentsController@showModuleContents');
        Route::post('/courses/{id}/modules/{idmod}/contents', 'Courses\CourseModuleContentsController@addModuleContent');
        Route::get('/courses/{id}/modules/{idmod}/contents/{idcon}', 'Courses\CourseModuleContentsController@showModuleContent');
        Route::post('/courses/{id}/modules/{idmod}/contents/{idcon}', 'Courses\CourseModuleContentsController@updateModuleContent');
        Route::delete('/courses/{id}/modules/{idmod}/contents/{idcon}', 'Courses\CourseModuleContentsController@deleteModuleContent');
    });
    /**
     * Routes for Users Management by UsersControllers 
     */
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/users', 'UsersController@showUsers');
        Route::get('/users/add', 'UsersController@NewUser');
        Route::post('/users/add', 'UsersController@addUser');
        Route::get('/users/{id}', 'UsersController@showUser');
        Route::post('/users/{id}', 'UsersController@updateUser');
        Route::delete('/users/{id}', 'UsersController@deleteUser');

        Route::get('/cupons', 'CuponeController@showCupones');
        Route::post('/cupons', 'CuponeController@addCupone');
        Route::get('/cupons/{idcup}', 'CuponeController@showCupone');
        Route::post('/cupons/{idcup}', 'CuponeController@updateCupone');
        Route::delete('/cupons/{idcup}', 'CuponeController@deleteCupon');
    });
    /**
     * Routes for Bills and pays by OrdersController
     */
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/orders', 'OrdersController@showOrders');
        //Route::post('/dashboard/orders', 'OrdersController@addOrder'); --> It's not possible
        Route::get('/orders/{id}', 'OrdersController@showOrderDetails'); 
        Route::post('/orders/{id}', 'OrdersController@updateOrderDetail');
    });
});

/* Route::get('/email', 'SendMailController@getEmail');
Route::post('/email', 'SendMailController@send'); */