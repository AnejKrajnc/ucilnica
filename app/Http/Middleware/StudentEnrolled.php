<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\CourseEnrolled;
use App\Course;

class StudentEnrolled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /* Handling request of student if is enrolled in Course or not */
    public function handle($request, Closure $next)
    {
        $course = Course::where('link', $request->tecaj)->firstOrFail(); 
        if (!empty(CourseEnrolled::where([['user_id', '=', Auth::id()], ['course_id', '=', $course->id]])->first())) {
            return $next($request);
        }
        else return redirect('/tecaji');
    }
    
}