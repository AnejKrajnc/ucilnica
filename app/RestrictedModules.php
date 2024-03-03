<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestrictedModules extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'restricted_modules';
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
    protected $fillable = ['module_id', 'user_id'];

    public function restrictedTo() {
        return $this->belongsTo(User::class);
    }
}
