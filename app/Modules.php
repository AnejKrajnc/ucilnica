<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    protected $fillable = ['order', 'title', 'description', 'module_link', ];
    
    /* Foreign key */
    public function moduleContent() {
        return $this->hasMany('App\ModuleContent', 'module_id', 'id');
    }
}
