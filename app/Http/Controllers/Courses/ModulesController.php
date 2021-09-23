<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Modules;
use App\ModuleContent;

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
        $course = Course::where('id', $request->id)->first();
        $modulecontents = ModuleContent::where('module_id', $request->idmod)->get();
        return view('admin.module')->withModule($module)->withCourse($course)->withModulecontents($modulecontents); 
    }
    public function updateModule(Request $request) {
        $module = Modules::where('id', $request->idmod)->first();
        $input = $request->all();
        $module->title = $input['imemodula'];
        $module->description = $input['opismodula'];
        $module->order = $input['order'];
        if ($request->file('slikica'))
            $module->thumbnail = str_replace('public', 'storage', $request->file('slikica')->store('public/images'));
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
