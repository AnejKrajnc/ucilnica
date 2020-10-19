<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProcess extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'order_process';
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
    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'naslov', 'kraj', 'postal', 'izdelek', 'payment', 'process_token'];

}
