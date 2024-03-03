<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Course extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'course';
    /**
     * The primary key associated with the table
     * 
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * Indicates if the IDs are auto-incrementing. 
     * 
     * @var bool
     */
    public $incrementing = true;
    /**
     * Columns of table.
     * 
     */
    protected $fillable = ['category_id', 'title', 'description', 'thumbnail', 'description_thumbnail', 'link', 'color'];

    public function modules() {
        return $this->hasMany('App\Modules');
    }

    public function usersEnrolled()
    {
        return $this->belongsToMany(User::class, 'course_enrolled', 'course_id', 'user_id');
    }
}
