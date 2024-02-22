<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Course;
use App\CourseEnrolled;
use App\Modules;
use App\ModuleContent;
use Illuminate\Support\Facades\Storage;

class FileStorageController extends Controller
{
    public function prenesi(Request $request)
    {
        if (Auth::check()) {
               $modulecontent = ModuleContent::where('content', $request->tecaj.'/'.$request->datoteka)->first();
               $pathToFile = "./locked/".explode("/", $modulecontent->content)[1]."";
               $fileExtension = explode(".", $pathToFile);
               if (empty($fileExtension[2])) {
                $fileExtension = ".pdf";
                return Storage::download($pathToFile.$fileExtension, $modulecontent->title.$fileExtension);
               }
               else {
                $fileExtension = "." . $fileExtension[2];
                return Storage::download($pathToFile, $modulecontent->title.$fileExtension);
               }
        }
    }
}
