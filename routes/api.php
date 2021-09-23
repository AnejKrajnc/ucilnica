<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Course;
use App\CourseEnrolled;
use App\Modules;
use App\ModuleContent;

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

Route::middleware('api')->get('/dashboard/getform/{action}', function ($action) {
    return view('admin.modal.addCourse');
});

Route::middleware('api')->get('/dashboard/courses/{id}', function ($id) {
    $course = Course::where('id', $id)->first();
    $modules = Modules::where('course_id', $id)->orderBy('order')->get();
    return view('admin.modal.viewCourse')->withCourse($course)->withModules($modules);
});

Route::middleware('api')->post('/dashboard/courses/{id}', function (Request $request)
{
    $data = $request->all();

    $course = Course::where('id', $request->id)->first();
    $course->title = $data['imetecaja'];
    $course->color = $data['barva'];
    $course->description = $data['opistecaja'];
    if ($request->file('slikica'))
        $course->thumbnail = str_replace('public', 'storage', $request->file('slikica')->store('public/images'));
    $course->save();
    return 'Spremembe uspešno shranjene!';
});

Route::middleware('api')->get('/dashboard/modulecontent/{id}', function ($id) {
    $modulecontent = ModuleContent::where('id', $id)->first();
    return view('admin.modal.viewModuleContent')->withModulecontent($modulecontent);
});

Route::middleware('api')->post('/dashboard/modulecontent/{id}', function (Request $request)
{
    $data = $request->all();

    $modulecontent = ModuleContent::where('id', $request->id)->first();
    $modulecontent->type = $data['tip'];
    $modulecontent->title = $data['naslov'];
    $modulecontent->content_link = $data['povezava'];
    if ($data['tip'] == 'eknjiga') {
        if($request->file('vsebina')->store('locked')) {
        $modulecontent->content = $request->file('vsebina')->store('locked');
        }
    }
    else {
        $modulecontent->content = $data['vsebina'];
    }
    $modulecontent->save();
    return 'Spremembe uspešno shranjene!';
});

Route::middleware('api')->get('/dashboard/users', function (Request $request)
{
    return view('admin.modal.addUser')->withTecaji(Course::all());
});

Route::middleware('api')->get('/dashboard/users/{id}', function (Request $request)
{
    $user = User::where('id', $request->id)->first();
    return view('admin.modal.editUser')->withUser($user)->withTecaji(Course::all());
});

Route::middleware('api')->post('/dashboard/users/change-info', function (Request $request)
{
    $data = $request->all();

    $user = User::where('id', $data['user'])->first();
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->save();
    return 'Podatki uporabnika ' . $user->name . ' uspešno posodobljeni!';
});

Route::middleware('api')->post('/dashboard/users/password-reset', function (Request $request) {
    $data = $request->all();

    $user = User::where('id', $data['user'])->first();
    $user->password = Hash::make($data['password']);
    $user->save();
    return 'Geslo uporabnika '. $user->name . ' uspešno nastavljeno!';
});

Route::middleware('api')->post('/dashboard/users/add-course', function (Request $request) {
    $data = $request->all();

    foreach ($data['tecaji'] as $tecaj) {
        CourseEnrolled::create([
            'user_id' => $data['user'],
            'course_id' => $tecaj,
            'enrolled_in' => NOW()
        ]);
}
    return 'Izbranemu uporabniku je bil spletni tečaj uspešno dodeljen!';
});

Route::middleware('api')->delete('/dashboard/users/remove-course', function (Request $request) {
    $data = $request->all();

    CourseEnrolled::where(['user_id'=> $data['user'], 'course_id' => $data['course']])->delete();
    return 'Izbranemu uporabniku je bil izbrisan zahtevan tečaj';
});

Route::middleware('api')->delete('/dashboard/users/{id}', function (Request $request) {
    CourseEnrolled::where('user_id', $request->id)->delete();
    User::where('id', $request->id)->delete();
    return 'Izbran uporabnik uspešno izbrisan!';
});

Route::middleware('api')->post('/dashboard/users', function (Request $request)
{
    $data = $request->all();

    $newUser = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'avatar' => 'users/default-png',
        'usertype' => 'student',
        'password' => Hash::make($data['password']),
        'created_at' => NOW(),
        'updated_at' => NOW()
    ]);

    foreach ($data['tecaji'] as $tecaj) {
        CourseEnrolled::create([
            'user_id' => $newUser->id,
            'course_id' => $tecaj,
            'enrolled_in' => NOW(),
            'progress' => 0.00
        ]);
    }
    return 'Nov uporabnik uspešno dodan!';
});
