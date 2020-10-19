<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Course;
use App\Modules;
use App\ModuleContent;

class CourseModuleContentsController extends Controller
{
    public function showModuleContents() {
        //
    }
    public function addModuleContent(Request $request) {
        $modulecontent = ModuleContent::create([
            'title' => 'Nova vsebina modula',
            'type' => 'video',
            'content' => 'povezava-do-videa',
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);

        $modulecontent->module_id = $request->idmod;

        $modulecontent->save();

        return redirect('/dashboard/courses/'.$request->id.'/modules/'.$request->idmod.'/contents/'.$modulecontent->id);
    }

    public function showModuleContent(Request $request) {
        $modulecontent = ModuleContent::where('id', $request->idcon)->first();
        $course = Course::where('id', $request->id)->first();
        $module = Course::where('id', $request->idmod)->first();
        return view('admin.modulecontent')->withModuleContent($modulecontent)->withCourse($course)->withModule($module);
    }

    public function updateModuleContent(Request $request) {
        $modulecontent = ModuleContent::where('id', $request->idcon)->first();
        $input = $request->all();

        $modulecontent->title = $input['imevsebine'];
        $modulecontent->type = $input['tipvsebine'];
        $modulecontent->content = $input['videopovezava'];
        $modulecontent->updated_at = NOW();

        $modulecontent->save();
        return redirect()->back()->with('success', 'Spremembe so bile shranjene!');
    }

    public function deleteModuleContent(Request $request) {
        $modulecontent = ModuleContent::where('id', $request->idcon)->first();
        $modulecontent->delete();
        
        return redirect('/dashboard/courses/'.$request->id.'/modules/'.$request->idmod)->with('alert-content', 'Vsebina Modula: '.$modulecontent->title.' je izbrisana!');
    }
    public function resolveVideo($url) {
        
    }
    public function resolveAudio($url) {

    }
    public function resolveEbook() {

    }
}
