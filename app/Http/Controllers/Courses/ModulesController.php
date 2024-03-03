<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\CourseEnrolled;
use App\Modules;
use App\ModuleContent;
use App\RestrictedModules;

class ModulesController extends Controller
{
    public function showModules() {
        //
    }
    public function addModule(Request $request) {
        $lastmodule = Modules::where('course_id', $request->id)->orderBy('order', 'desc')->first()->order;
        $module = Modules::create([
            'order' => 0,
            'title' => 'Ime modula',
            'description' => 'Kratek opis modula',
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);
        $module->order = ++$lastmodule;
        $module->course_id = $request->id;

        $module->save();

        $course = Course::where('id', $request->id)->first();
        return redirect('/dashboard/courses/'.$request->id.'/modules/'.$module->id);
    }
    public function showModule(Request $request) {
        $module = Modules::where('id', $request->idmod)->first();
        $restrictedModules = RestrictedModules::join('users', 'users.id', '=', 'restricted_modules.user_id')->where('module_id', $request->idmod)->get();
        $course = Course::where('id', $request->id)->first();
        $usersInCourse = CourseEnrolled::join('users', 'users.id', '=', 'course_enrolled.user_id')->where('course_id', $request->id)->get();
        $modulecontents = ModuleContent::where('module_id', $request->idmod)->get();
        return view('admin.module')->withModule($module)->withCourse($course)->withModulecontents($modulecontents)->withRestrictedmodules($restrictedModules)->withUsersincourse($usersInCourse); 
    }

    public function restrictModule(Request $request) {
        $restrictedModule = RestrictedModules::create([
            'module_id' => $request->idmod,
            'user_id' => $request->userid
        ]);

        return redirect()->back()->with('success', 'Spremembe so bile shranjene!');
    }

    public function deleteRestrictedModule(Request $request) {
        $restrictedModule = RestrictedModules::where('module_id', $request->idmod)->where('user_id', $request->userid);

        if ($restrictedModule->delete() == 1) {
            return redirect()->back()->with('success', 'Spremembe so bile shranjene!');
        } else {
            return redirect()->back()->with('error', 'Pri odstranjevanju omejitve dostopa izbranemu uporabniku je prišlo do napake!');
        }
    }

    public function updateModule(Request $request) {
        $module = Modules::where('id', $request->idmod)->first();
        $input = $request->all();
        $module->title = $input['imemodula'];
        $module->description = $input['opismodula'];
        $module->order = $input['order'];
        if ($request->file('slikica'))
            $module->thumbnail = 'storage/'.$request->file('slikica')->store('images');
        $module->updated_at = NOW();
        $module->save();
        return redirect()->back()->with('success', 'Spremembe so bile shranjene!');
    }
    public function deleteModule(Request $request) {
        $module = Modules::where('id', $request->idmod)->first();
        $module->delete();
        return redirect('/dashboard/courses/'.$request->id)->with('moduledelete', 'Modul: '.$module->title.' je izbrisan!');
    }
}
