<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\RestrictedModules;

class Modules extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'modules';
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
    protected $fillable = ['order', 'title', 'description', 'thumbnail', 'course_id'];
    
    /* Foreign key */
    public function moduleContent() {
        return $this->hasMany('App\ModuleContent', 'module_id', 'id');
    }

    public function restricted() {
        return $this->hasMany(RestrictedModules::class, 'module_id');
    }
}
