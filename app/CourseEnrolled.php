<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseEnrolled extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'course_enrolled';
    /**
     * The primary key associated with the table
     * 
     * @var string
     */
    //protected $primaryKey = 'id';
    /**
     * Indicates if the IDs are auto-incrementing. 
     * 
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;
    /**
     * Columns of table.
     * 
     */
    protected $fillable = ['user_id', 'course_id', 'enrolled', 'progress'];
}
