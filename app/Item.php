<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'items';
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
    public $incrementing = true;
    public $timestamps = false;
    /**
     * Columns of table.
     * 
     */
    protected $fillable = ['name', 'description', 'price', 'course_id'];
}
