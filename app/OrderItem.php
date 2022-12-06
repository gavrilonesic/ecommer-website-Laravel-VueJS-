<?php

namespace App;

use App\OrderStatusHistory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderItem
 * @package App
 *
 * @property integer $tracking_provider_id
 * @property string  $carrier_name
 */

class OrderItem extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($callback) {
            if (isset($callback->changes['order_status_id'])) {
                OrderStatusHistory::create([
                    'order_item_id'   => $callback->id,
                    'order_status_id' => $callback->order_status_id,
                ]);
            }
        });

        static::created(function ($callback) {
            OrderStatusHistory::create([
                'order_item_id'   => $callback->id,
                'order_status_id' => $callback->order_status_id,
            ]);
        });
    }

    public function product()
    {
        return $this->belongsTo('App\Product')->withTrashed();
    }

    public function productSku()
    {
        return $this->belongsTo('App\ProductSku');
    }

    public function order()
    {
        return $this->belongsTo('App\Order')->active();
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus', 'order_status_id');
    }

    public function orderStatusHistory()
    {
        return $this->belongsToMany('App\OrderStatusHistory', 'order_status_histories');
    }

    public function orderStatusHistoryById($item_id = null, $itemstatusid = null)
    {
        $data = OrderStatusHistory::select('created_at', 'order_status_id')->where('order_item_id', $item_id)->where('order_status_id', $itemstatusid)->orderBy('created_at', 'DESC')->first();

        return $data;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function setVariationsAttribute($value)
    {
        $this->attributes['variations'] = json_encode(!empty($value) ? $value : []);
    }

    public function getVariationsAttribute()
    {
        return json_decode($this->attributes['variations']);
    }

    public function getCarrierName(): string
    {
    	if ($this->tracking_provider_id == config('constants.CUSTOM_SHIPPING_PROVIDER_ID'))
    		return $this->carrier_name;

    	return config('constants.SHIPPING_PROVIDERS')[$this->tracking_provider_id];
    }
}
