<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuponCode extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'cupones';
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
    public $timestamps = false;
    /**
     * Columns of table.
     * 
     */
    protected $fillable = ['code', 'discount', 'added_on', 'expires'];

}
