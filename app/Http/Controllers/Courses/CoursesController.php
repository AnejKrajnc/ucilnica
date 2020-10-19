<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Course;
use App\Modules;
use App\ModuleContent;

class CoursesController extends Controller
{
    public function showCourses() {
        $courses = Course::all();
        return view('courses');
    }
    public function addCourse(Request $request) {
        $course = new Course;
        $course->title = "Nov spletni tečaj";
        $course->thumbnail = "privzeto.png";
        $course->link = "povezava";
        $course->save();
        return redirect('/courses/'.$course->id);
    }
    public function showCourse(Request $request) {
        $course = Course::where('id', $request->id)->first();
        $modules = Modules::where('course_id', $request->id)->orderBy('order')->get();
        return view('admin.course')->withCourse($course)->withModules($modules);
    }
    public function updateCourse(Request $request) {
        $courseID = request('id');
        $course = Course::where('id', $courseID)->first();
        $input = $request->all();
        $course->title = $input['imetecaja'];
        $course->description = $input['opistecaja'];
        if($request->hasFile('slikica')) {
            if($request->file('slikica')->isValid()) {
                $validated = $request->validate([
                    'name' => 'string|max:40',
                    'image' => 'mimes:jpeg,png|max:1014'
                ]);
                $extension = $request->slikica->extension();
                $request->slikica->storeAs('/public/images', $validated['name'].".".$extension);
                $url = Storage::url($validated['name'].".".$extension);
                $file = File::create([
                    'name' => $validated['name'],
                    'url' => $url
                ]);
                $course->thumbnail = $validated['name'].$extension;
            }
        }
        $course->link = implode('-', explode(' ', Str::lower($course->title)));
        $course->save();
        return redirect()->back()->with('success', 'Spremembe so bile shranjene!');
    }
    public function deleteCourse(Request $request) {
        $courseID = $request->course;
        $course = Course::where('id', $courseID)->get();
        $course->delete();
        return redirect('/courses');
    }
}
