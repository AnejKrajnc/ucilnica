<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'categories';
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
    public $timestamps = true;
    /**
     * Columns of table.
     * 
     */
    protected $fillable = ['name', 'thumbnail', 'slug'];

    public function tecaji() {
        return $this->hasMany('App\Course');
    }
}
