<?php

namespace App\Http\Controllers\Front;

use Auth;
use JsValidator;
use App\CartStorage;
use App\ShippingSetting;
use App\{ User, Order };
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Custom\UpsShipping\UpsHandler;
use App\Http\Controllers\Front\FrontController;
use App\Custom\UpsShipping\SoapRequest\SoapFreightRatesRequest;

class ShippingController extends FrontController
{
    public function index(Request $request)
    {
        $validator = JsValidator::make([
            'shipping_setting_id'     => 'required',
            'shipping_quotes'         => Rule::requiredIf(function () use ($request) {
                return $request->shipping_setting_id == 'own_shipping' ? false : true;
            }),
            'shipping_service_name'   => 'required_if:shipping_setting_id,own_shipping',
            'shipping_account_number' => 'required_if:shipping_setting_id,own_shipping',
        ], [
            'shipping_setting_id.required'        => __('messages.this_field_is_required'),
            'shipping_quotes.required'            => __('messages.this_field_is_required'),
            'shipping_service_name.required_if'   => __('messages.this_field_is_required'),
            'shipping_account_number.required_if' => __('messages.this_field_is_required'),
        ]);

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
        } else {
            $user = User::firstWhere('email', $request->email);
        }

        $shippingSettings = ShippingSetting::getShippingZone($request);

        $isHazmat = CartStorage::isHazmat();

        if (CartStorage::weight() > 150) {
            try {

                $cart = CartStorage::getCart();
                $address = session('shipping_details');

                $response = app('UpsSoapClient')->makeRequest(
                    new SoapFreightRatesRequest($cart, $address, [
                        'Code' => '308',
                        'Description' => 'UPS Freight LTL',
                    ])
                );

                if (! isset($response->TotalShipmentCharge)) {
                    throw new \Exception("Something went wrong. Please check your address.");
                }

                if (! isset($response->TotalShipmentCharge->MonetaryValue)) {
                    throw new \Exception("Something went wrong. Please check your address.");
                }

                $couriers = [
                    [
                        'label' => 'UPS Freight LTL',
                        'code' => '308',
                        'description' => 'UPS Freight LTL',
                        'rate'  => ($response->TotalShipmentCharge->MonetaryValue + round($response->TotalShipmentCharge->MonetaryValue * config('ups.percentage_increase'), 2))
                    ]
                ];

                if(array_key_exists('state_name', $address) && $address['state_name'] == "Michigan"){
                    $pickupAvailable = TRUE;
                } else {
                    $pickupAvailable = FALSE;
                }

                if (! CartStorage::canShipByAir() || $isHazmat) {
                    $response = app('UpsSoapClient')->makeRequest(
                        new SoapFreightRatesRequest($cart, $address, [
                            'Code' => '349',
                            'Description' => 'Standard LTL',
                        ])
                    );

                    $couriers = [
                        [
                            'label' => 'Standard LTL',
                            'code' => '349',
                            'description' => 'Standard LTL',
                            'rate'  => ($response->TotalShipmentCharge->MonetaryValue + round($response->TotalShipmentCharge->MonetaryValue * config('ups.percentage_increase'), 2))
                        ]
                    ];
                }

                return view('front.shipping.index', compact('shippingSettings', 'validator', 'user', 'couriers', 'isHazmat', 'pickupAvailable'));
            // } catch (\SoapFault $e) {
            //     logger(json_encode($e->detail));
            } catch (\Exception $e) {
                logger('Error getting LTL rate:');
                logger($e->getMessage());
                throw new \Exception("Something went wrong. Please check your address.");
            }
        } else {
            $couriersArr = [
                [
                    'label' => 'UPS Ground',
                    'code' => '03',
                    'description' => 'UPS Ground',
                    'rate'  => 'N/A'
                ]
            ];
        }

        if ((! $isHazmat) && CartStorage::canShipByAir()) {
            $couriersArr[] = [
                'label' => 'UPS 2nd Day Air',
                'code' => '02',
                'description' => 'UPS 2nd Day Air',
                'rate'  => 'N/A'
            ];
        }

        $address = session('shipping_details');
        if(array_key_exists('state_name', $address) && $address['state_name'] == "Michigan"){
            $pickupAvailable = TRUE;
        } else {
            $pickupAvailable = FALSE;
        }

        try {
            $couriers = $this->getLegibleCouriers($shippingSettings, $couriersArr, $request);
        } catch (\Exception $e) {
            $couriers = [];
        }

        return view('front.shipping.index', compact('shippingSettings', 'validator', 'user', 'couriers', 'isHazmat', 'pickupAvailable'));
    }

    public function getShippingQuotes(Request $request, $isJson = FALSE)
    {
        $shippingSetting = ShippingSetting::find($request->id);

        if (!empty($shippingSetting->value)) {
            foreach (config('constants.SHIPPING_QUOTES') as $key => $shippingQuote) {
                if (isset($shippingSetting->value->$key) && $shippingSetting->value->$key->is_enabled == 1) {

                    if ($shippingQuote['view'] == 'truck_freight_shipping' && isset($shippingSetting->value->$key->freight_name)) {
                        $shippingQuotes[$key] = __('messages.' . $shippingQuote['view']) . ' - ' . ucwords($shippingSetting->value->$key->freight_name);
                    } else {
                        $shippingQuotes[$key] = __('messages.' . $shippingQuote['view']);
                    }
                }
            }
        }
        if(!$isJson) {
            return $shippingSetting;
        }

        return response()->json([
            'shippingQuotes' => !empty($shippingQuotes) ? $shippingQuotes : [],
            'status'         => "success",
        ]);

    }

    /**
     * Get UPS courier costs
     *
     * @param  boolean $isLtl
     * @return collection
     */
    public function getLegibleCouriers($shippingSettings, $couriers, Request $request)
    {
        if (isset($shippingSettings[0]) && (int)$shippingSettings[0]->country_id !== config('constants.DEFAULT_COUNTRY_ID')) {
            try {
                $shippingSetting = $shippingSettings[0]->value;
                return array(array_map(function($courier) use($shippingSetting) {
                    if ($courier['rate'] === 'N/A') {
                        if (isset($shippingSetting->flat_rate) && (bool)$shippingSetting->flat_rate->is_enabled) {
                            if (!isset($shippingSetting->flat_rate->shipping_rate)) {
                                throw new \Exception('no flat rate set');
                            }
                            $courier['rate'] = floatval($shippingSetting->flat_rate->shipping_rate);
                            return $courier;
                        } elseif (isset($shippingSetting->truck_freight_shipping) && (bool)$shippingSetting->truck_freight_shipping->is_enabled) {
                            $weight = CartStorage::weight();
                            $rate = 0;
                            foreach($shippingSetting->truck_freight_shipping->ranges as $range) {
                                if (floatval($range->from) <= $weight && floatval($range->to) > $weight) {
                                    $rate = floatval($range->cost);
                                    break;
                                }
                            }
                            return [
                                'label'       => $shippingSetting->truck_freight_shipping->freight_name,
                                'description' => $shippingSetting->truck_freight_shipping->freight_name,
                                'rate'        => $rate,
                                'code'        => '0',
                            ];
                        }
                    }
                }, $couriers)[0]);
            } catch(\Exception $e) {
                //logger($e->getMessage());
            }
        }

        app('UpsHandler')->initUpsRepository($request);

        $ratedCouriers = $couriers;

        $i = 0;

        foreach ($couriers as $courier) {
            try {

                $ratedCouriers[$i]['rate'] = app('UpsHandler')->setOrder(session('order', new Order))->setCourier($couriers[$i]['code'])->getCost($request);

                $ratedCouriers[$i]['rate'] += round(( $ratedCouriers[$i]['rate'] * config('ups.percentage_increase') ), 2);

                $i = $i + 1;
            } catch (\Exception $e) {

            }
        }

        return $ratedCouriers;
    }

    public function shippingCalculation(Request $request)
    {
        if(gettype($request->shipping_quotes) == 'string') {
            $shippingArr = explode('_', $request->shipping_quotes);
            $shippingSetting = [
                'shipping_cost' => $shippingArr[1],
                'shipping_text' => setting('currency_symbol') . floatval($shippingArr[1]),
                'shipping_option_chosen' => $shippingArr[0]
            ];
            session()->put('shipping_option_chosen', $shippingArr[0]);
            session()->put('shipping_cost', $shippingArr[1]);
        } else {
            $shippingSetting = ShippingSetting::shippingCalculation($request);
        }
        if (!isset($shippingSetting['error'])) {

            if ($shippingSetting['shipping_cost'] == 'shipping') {
                $shippingSetting['shipping_cost'] = 0;
            }

            return response()->json([
                'shipping' => $shippingSetting,
                'status'   => "success",
            ]);
        } else {
            return response()->json([
                "status"  => "error",
                "message" => "Something went wrong.",
            ]);
        }
    }

}
