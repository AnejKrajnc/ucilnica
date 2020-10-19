<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    protected $fillable = ['title', 'description', 'thumbnail', 'description_thumbnail', 'link', 'color'];

    public function modules() {
        return $this->hasMany('App\Modules');
    }
}
