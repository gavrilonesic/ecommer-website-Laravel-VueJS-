<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use SoftDeletes;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'status'];
    protected $table    = 'order_status';

    public function orderItemStatusHistory()
    {
        return $this->belongsToMany('App\OrderItem', 'order_status_histories');
    }
}
