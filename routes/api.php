<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Course;
use App\CourseEnrolled;
use App\Modules;
use App\ModuleContent;
use App\RestrictedModules;
use App\Mail\NewUserNotification;

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
    $course = Course::create([
        'title' => 'Novo dodan spletni tečaj',
        'category_id' => 1,
        'description' => '...',
        'link' => 'link-do-tecaja'
    ]);
    $modules = NULL;
    return view('admin.modal.viewCourse')->withCourse($course)->withModules($modules);
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
    $course->category_id = $data['kategorija_id'];
    $course->link = $data['linktecaja'];
    $course->description = $data['opistecaja'];
    if ($request->file('slikica'))
        $course->thumbnail = 'storage/'.$request->file('slikica')->store('images');
    $course->save();
    return 'Spremembe uspešno shranjene!';
});

Route::middleware('api')->post('/dashboard/courses/{id}/modules', function (Request $request)
{
    $module = Modules::create([
        'order',
         'title' => 'Nov dodan modul',
          'description' => 'Opis',
          'course_id' => $request->id
    ]);

    return response()->json($module);
});

Route::middleware('api')->post('/dashboard/restrictedmodules', function (Request $request)
 {

    if (RestrictedModules::where('module_id', $request->module_id)->where('user_id', $request->user_id)) {
        return response()->json(['success' => false]);
    }

    $restrictedmodule = RestrictedModule::create([
        $request->module_id,
        $request->user_id
    ]);

    return response()->json($restrictedmodule);
});

Route::middleware('api')->delete('/dashboard/restrictedmodules', function (Request $request) 
{
    $restrictedmodule = RestrictedModules::where('module_id', $request->module_id)->where('user_id', $request->user_id);

    if ($restrictedmodule->delete() == 1) {
        return response()->json(['success' => true]);
    }
    else {
        return response()->json(['success' => false]);
    }
});

Route::middleware('api')->delete('/dashboard/courses/{id}', function (Request $request)
{
    $course = Course::where('id', $request->id);

    if ($course->delete() == 1) {
        return response()->json(['success' => true]);
    }
    else {
        return response()->json(['success' => false]);
    }
});

Route::middleware('api')->post('/dashboard/courses/{courseid}/modules/{moduleid}/contents', function (Request $request)
{
    $modulecontent = ModuleContent::create([
        'title' => 'Nova vsebina modula',
        'type' => 'video',
        'content' => 'povezava-do-videa',
        'created_at' => NOW(),
        'updated_at' => NOW()
    ]);

    $modulecontent->module_id = $request->moduleid;
    $modulecontent->save();

    return response()->json($modulecontent);
});

Route::middleware('api')->delete('/dashboard/modulecontent/{modulecontentid}', function (Request $request)
{
    $modulecontent = ModuleContent::where('id', $request->modulecontentid);
    if($modulecontent->delete() == 1) {
        return response()->json(['success' => true]);
    }
    else
        return response()->json(['success' => false]);
});

Route::middleware('api')->get('/dashboard/modulecontent/{id}', function ($id) {
    $modulecontent = ModuleContent::where('id', $id)->first();
    return view('admin.modal.viewModuleContent')->withModulecontent($modulecontent);
});

Route::middleware('api')->post('/dashboard/modulecontent/{id}', function (Request $request)
{
    $data = $request->all();

    $modulecontent = ModuleContent::where('id', $request->id)->first();
    $module = $modulecontent->module_id;
    $modulecontent->type = $data['tip'];
    $modulecontent->title = $data['naslov'];
    $modulecontent->content_link = $data['povezava'];
    if ($data['tip'] == 'eknjiga') {
        if($request->file('vsebina')) {
        $modulecontent->content = Course::find(Modules::find($module)->first()->course_id)->first()->link.'/'. basename($request->file('vsebina')->store('locked'), '.pdf');
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

Route::middleware('api')->post('/dashboard/users/{id}/change-info', function (Request $request)
{
    $data = $request->all();

    $user = User::where('id', $request->id)->first();
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

    if (empty($data['password']) || $data['password'] == "") {
        // Create new user and send welcome mail with link to activate account and set password
        $registration_token = Str::random(40);

        $newUser = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'avatar' => 'users/default-png',
        'usertype' => 'student',
        'registration_token' => $registration_token,
        'created_at' => NOW(),
        'updated_at' => NOW()
    ]);

    $data['registration_token'] = $registration_token;

    // Send welcome email to given email with registration link
    Mail::to($data['email'])->send(new NewUserNotification($data));

    } else {
        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => 'users/default-png',
            'usertype' => 'student',
            'password' => Hash::make($data['password']),
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);
    }

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

Route::middleware('api')->get('/dashboard/courses/filterbytype/{type}', function (Request $request) {
    if($request->type == 0)
    {$courses = Course::all();}
    else {
    $courses = Course::where('category_id', $request->type)->get(); }
    return response()->json($courses);
});