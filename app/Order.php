<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model. 
     * 
     * @var string
     */
    protected $table = 'orders';
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
    protected $fillable = ['customer_id', 'order_status', 'order_date'];

    public function customer() {
        return $this->hasOne('App\Customer');
    }
}
