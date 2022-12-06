<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as Auditing;

class Order extends Model implements Auditing
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus', 'order_status_id');
    }

    public function payment()
    {
        return $this->belongsTo('App\PaymentSetting', 'payment_setting_id');
    }

    public function coupons()
    {
        return $this->belongsToMany('App\Coupon', 'coupon_user');
    }

    public function getPaymentResponseAttribute($value)
    {
        if (!empty($value)) {
            return json_decode($value);
        } else {
            return $value;
        }
    }

    /**
     * Get the customer full name
     *
     * @return string full name
     */
    public function getNameAttribute()
    {
        // return "{$this->first_name} {$this->last_name}";
        return "{$this->billing_first_name} {$this->billing_last_name}";
    }

    public function getAddressAttribute()
    {
        $address = $this->shipping_address_1 . ", ";
        $address .= !empty($this->shipping_address_2) ? $this->shipping_address_2 . ", " : '';
        $address .= $this->shipping_city . ', ' . $this->shipping_state . ', ' . $this->shipping_postcode . ', ' . $this->shipping_country;
        return $address;
    }

    public static function getOrder($orderId, $orderItemId = null)
    {
        return Order::with(['orderItems.product' => function ($query) {
            $query->select('id', 'name', 'brand_id', 'inventory_tracking', 'inventory_tracking_by')->with(['brand', 'medias' => function ($query) {
                $query->whereJsonContains('custom_properties->default_image', true);
            }]);
        }, 'orderItems' => function ($query) use ($orderItemId) {
            if (!empty($orderItemId) && !is_array($orderItemId)) {
                $query->where('id', $orderItemId);
            }
            if (!empty($orderItemId) && is_array($orderItemId)) {
                $query->whereIn('id', $orderItemId);
            }
            $query->with('productSku.medias');
        }])->find($orderId);
    }
    public function UpdateRefundAmount()
    {
        return OrderItem::select(DB::RAW("((sum(price) - sum(discount)) * quantity) as refund"))->where('order_id', $this->id)->where('order_status_id', config('constants.ORDER_STATUS.DECLINED_CANCELLED'))->groupBy('order_id')->pluck('refund')->first();
    }
    public static function sales($from, $to)
    {
        if (!$from || $from == "") {
            $fromCarbon = Carbon::now()->addMonths(-1);
            $from       = $fromCarbon->toDateTimeString();
        } else {
            $fromCarbon = Carbon::createFromFormat('m/d/Y', $from)->setTime(0, 0, 0);
            $from       = $fromCarbon->toDateTimeString();
        }
        if (!$to || $to == "") {
            $toCarbon = Carbon::now()->setTime(23, 59, 59);
            $to       = $toCarbon->toDateTimeString();
        } else {
            $toCarbon = Carbon::createFromFormat('m/d/Y', $to)->setTime(23, 59, 59);
            $to       = $toCarbon->toDateTimeString();
        }

        $diffDays    = $toCarbon->diff($fromCarbon)->days;
        $groupFormat = "Y-m";
        $period      = 1;
        if ($diffDays < 1) {
            $groupFormat = "H:00";
        } elseif ($diffDays < 40) {
            $groupFormat = "m/d/Y";
        } elseif ($diffDays < 500) {
            $groupFormat = "M Y";
        } else {
            $groupFormat = "Y";
        }

        $salesAll = Order::active()->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->get();

        $sales = $salesAll->groupBy(function ($date) use ($groupFormat) {
            return Carbon::parse($date->created_at)->format($groupFormat);
        });

        $salesData = [];
        $labels    = [];

        $date = $fromCarbon;
        while ($date < $toCarbon) {
            $key      = $date->format($groupFormat);
            $labels[] = $key;
            if (isset($sales[$key])) {
                $salesSum = 0;
                foreach ($sales[$key] as $sale) {
                    $salesSum += ($sale->order_total - $sale->refund_total);
                }
                $salesData[] = ceil($salesSum);
            } else {
                $salesData[] = 0;
            }

            if ($diffDays < 1) {
                $date->addHours(1);
            } elseif ($diffDays < 40) {
                $date->addDays(1);
            } elseif ($diffDays < 500) {
                $date->addMonths(1);
            } else {
                $date->addYears(1);
            }
        }

        return [
            'error'     => false,
            'chartData' => [
                "labels" => $labels,
                "label"  => "Sales",
                "data"   => $salesData,
            ],
        ];
    }
    public function getShippingAdress()
    {
        $shippingAdress = '';
        if (!empty($this->first_name)) {
            $shippingAdress .= $this->first_name . ' ';
        }
        if (!empty($this->last_name)) {
            $shippingAdress .= $this->last_name . '<br/>';
        }
        if (!empty($this->shipping_address_name)) {
            $shippingAdress .= $this->shipping_address_name . '<br/>';
        }
        if (!empty($this->shipping_address_1)) {
            $shippingAdress .= $this->shipping_address_1 . '<br/>';
        }
        if (!empty($this->shipping_address_2)) {
            $shippingAdress .= $this->shipping_address_2 . '<br/>';
        }
        if (!empty($this->shipping_city)) {
            $shippingAdress .= $this->shipping_city . ', ';
        }
        if (!empty($this->shipping_state)) {
            $shippingAdress .= $this->shipping_state . ' ';
        }
        if (!empty($this->shipping_postcode)) {
            $shippingAdress .= $this->shipping_postcode . '<br/>';
        }
        if (!empty($this->shipping_country)) {
            $shippingAdress .= $this->shipping_country;
        }
        return $shippingAdress;

    }
    public function getBillingAdress()
    {
        $billingAdress = '';
        if (!empty($this->billing_first_name)) {
            $billingAdress .= $this->billing_first_name . ' ';
        }
        if (!empty($this->billing_last_name)) {
            $billingAdress .= $this->billing_last_name . '<br/>';
        }
        if (!empty($this->billing_address_name)) {
            $billingAdress .= $this->billing_address_name . '<br/>';
        }
        if (!empty($this->billing_address_1)) {
            $billingAdress .= $this->billing_address_1 . '<br/>';
        }
        if (!empty($this->billing_address_2)) {
            $billingAdress .= $this->billing_address_2 . '<br/>';
        }
        if (!empty($this->billing_city)) {
            $billingAdress .= $this->billing_city . ', ';
        }
        if (!empty($this->billing_state)) {
            $billingAdress .= $this->billing_state . ' ';
        }
        if (!empty($this->billing_postcode)) {
            $billingAdress .= $this->billing_postcode . '<br/>';
        }
        if (!empty($this->billing_country)) {
            $billingAdress .= $this->billing_country;
        }
        return $billingAdress;

    }
    public function scopeActive($query)
    {
        return $query->where('payment_status', 1);
    }
    public function scopeDeactive($query)
    {
        return $query->where('payment_status', 0);
    }
}
