<?php
namespace App;

use App\CartStorage;
use App\UserAddress;
use Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingSetting extends Model
{
    use SoftDeletes;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;

    protected $fillable = [
        'title', 'country_id', 'country_name', 'state_id', 'state_name', 'shipping_zone', 'status', 'value',
    ];

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = json_encode(!empty($value) ? $value : []);
    }
    public function getValueAttribute($value)
    {
        return json_decode($this->attributes['value']);
    }

    public static function getShippingZone($request)
    {
        $shippingDetails = $request->session()->get('shipping_details');

        $shippingSettings = self::where('status', config('constants.STATUS.STATUS_ACTIVE'));
        if (!empty($shippingDetails) && $shippingDetails['address_option'] == 0) {
            $address = UserAddress::find($shippingDetails['address']);
            if (!empty($address) && $address->country_id) {
                $countryId = $address->country_id;
            }
            if (!empty($address) && !empty($address->state_id)) {
                $stateId = $address->state_id;
            }
        } else if (!empty($shippingDetails)) {
            $countryId = $shippingDetails['country_id'];
            $stateId = !empty($shippingDetails['state_id']) ? $shippingDetails['state_id'] : '';
        }

        if (!empty($stateId)) {
            $shipping = self::where('status', config('constants.STATUS.STATUS_ACTIVE'))
                ->where('state_id', $stateId)
                ->where('shipping_zone', 1)->get();
            if ($shipping->count() > 0) {
                return $shipping;
            }
        }
        if (!empty($countryId)) {
            $shipping = self::where('status', config('constants.STATUS.STATUS_ACTIVE'))
                ->where('country_id', $countryId)
                ->where('shipping_zone', 0)->get();
            if ($shipping->count() > 0) {
                return $shipping;
            }
        }

        return self::where('status', config('constants.STATUS.STATUS_ACTIVE'))->where('shipping_zone', 2)->get();
    }

    public static function shippingCalculation($request)
    {
        if ($request->shipping_setting_id == 'own_shipping') {
            return [
                'shipping_cost' => 0,
                'shipping_text' => __('messages.free'),
            ];
        }
        $shippingSetting = self::find($request->shipping_setting_id);
        $value           = $shippingSetting->value ?? '';
        $shippingQuote   = $request->shipping_quotes;
        //if (!empty($shippingSetting) && !empty($value->$shippingQuote) && $value->$shippingQuote->is_enabled == 1) {
        switch ($shippingQuote) {
            case 'free_shipping':
                return [
                    'shipping_cost' => 0,
                    'shipping_text' => __('messages.free'),
                ];
                break;
            case 'truck_freight_shipping':
                if ($value->truck_freight_shipping->charge_shipping == 1) {
                    $chargeShipping = 'weight';
                } else if ($value->truck_freight_shipping->charge_shipping == 2) {
                    $chargeShipping = 'price';
                }
                extract(CartStorage::grandTotalCalculate($chargeShipping));
                $cost = 0;
                if (!empty($value->truck_freight_shipping->ranges)) {
                    foreach ($value->truck_freight_shipping->ranges as $range) {
                        if ($range->from <= $grandTotal && $range->to >= $grandTotal) {
                            $cost = $range->cost;
                            break;
                        } else {
                            if ($range->cost > $cost) {
                                $cost = $range->cost;
                            }
                        }
                    }
                }
                return [
                    'shipping_cost' => $cost,
                    'shipping_text' => setting('currency_symbol') . number_format(round($cost, 2), 2),
                ];
                break;
            case 'flat_rate':
                $totalItems = Cart::session(CartStorage::getSession())->getTotalQuantity();
                if ($value->flat_rate->type == 1) {
                    $cost = $value->flat_rate->shipping_rate;
                } else {
                    $cost = $value->flat_rate->shipping_rate * $totalItems;
                }
                return [
                    'shipping_cost' => $cost,
                    'shipping_text' => setting('currency_symbol') . number_format(round($cost, 2), 2),
                ];
                break;
            case 'pickup_in_store':
                return [
                    'shipping_cost'   => 0,
                    'store_address'   => $value->pickup_in_store->store_address,
                    'shipping_text'   => __('messages.free'),
                    'pick_from_store' => 1,
                ];
                break;
        }

        return ['error' => 1];
    }
}
