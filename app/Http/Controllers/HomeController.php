<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Course;
use App\CourseEnrolled;
use App\Modules;
use App\ModuleContent;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $courses = Auth::user()->courses()->get();
        return view('tecajipogled')->withCourses($courses);
    }
    public function tecaji(Request $request)
    {
        $course = Course::where('link', $request->tecaj)->first();
        $modules = Modules::where('course_id', $course->id)->orderBy('order')->get();
        $ikone = ['video' => 'fa-video-camera', 'meditacija' => 'fa-headphones', 'eknjiga' => 'fa-book'];
        return view('tecaj', ['course' => $course, 'modules' => $modules, 'ikone' => $ikone]);
    }
    public function myprofile()
    {

        return view('myprofile');
    }
    public function changemyprofile(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        if(Hash::check($data['currentpasswd'], $user->password) && ($data['newpasswd'] == $data['verifynewpasswd']))
        {
            $user->password = Hash::make($data['newpasswd']);
            $user->save();
            return redirect()->back()->with('message', 'Vaše geslo je bilo spremenjeno!');
        }
        else {
            if(!(Hash::check($data['currentpasswd'], $user->password))) return redirect()->back()->with('message', 'Staro geslo ni pravilno!');
            if(!($data['newpasswd'] == $data['verifynewpasswd'])) return redirect()->back()->with('message', 'Novo geslo se ne ujema!');
        }
    }
    public function prenesi(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->courses()->get()->link == $request->tecaj) {
               $modulecontent = ModuleContent::where('title', $request->datoteka)->first();
               $pathToFile = $modulecontent->content;
               return response()->download($pathToFile);
            }
        }
        else
            exit;
    }
}
