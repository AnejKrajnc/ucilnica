<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleContent extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'modulecontent';
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
    protected $fillable = ['title', 'type', 'content'];
    /* Foreign key */
    public function Modules() {
        return $this->hasOne('App\Modules');
    }
}
