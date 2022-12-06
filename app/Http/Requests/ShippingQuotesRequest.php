<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ShippingQuotesRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Request::isMethod('get')) {
            return [
                'shipping_charge.ranges.*.from'  => 'required_if:id,truck_freight_shipping',
                'shipping_charge.ranges.*.to'    => 'required_if:id,truck_freight_shipping',
                'shipping_charge.ranges.*.from'  => 'required_if:id,truck_freight_shipping',
                'shipping_charge[shipping_rate]' => 'required_if:id,flat_rate',
                'shipping_charge[store_address]' => 'required_if:id,pickup_in_store',
            ];
        } else if (Request::isMethod('post')) {
            return [
                'shipping_charge.ranges.*.from' => 'required_if:id,truck_freight_shipping',
                'shipping_charge.ranges.*.to'   => 'required_if:id,truck_freight_shipping',
                'shipping_charge.ranges.*.from' => 'required_if:id,truck_freight_shipping',
                'shipping_charge.shipping_rate' => 'required_if:id,flat_rate',
            ];
        }

        /*if ((Request::input('method') == 'post') && (Request::isMethod('put'))) {
    return [
    'ps.rate' => 'required|numeric|min:0.1',
    ];
    } elseif ((Request::input('method') == 'ups') && (Request::isMethod('put'))) {
    return [
    'ps.mode'               => 'required',
    'ps.sandbox.access_key' => 'required_if:ps.mode,0',
    'ps.live.access_key'    => 'required_if:ps.mode,1',
    'ps.sandbox.user_id'    => 'required_if:ps.mode,0',
    'ps.live.user_id'       => 'required_if:ps.mode,1',
    'ps.sandbox.password'   => 'required_if:ps.mode,0',
    'ps.live.password'      => 'required_if:ps.mode,1',
    ];
    } elseif (Request::isMethod('get')) {
    return [
    'ps.rate' => 'required|numeric|min:0.1',
    'ps.mode'               => 'required',
    'ps.sandbox.access_key' => 'required_if:ps.mode,0',
    'ps.live.access_key'    => 'required_if:ps.mode,1',
    'ps.sandbox.user_id'    => 'required_if:ps.mode,0',
    'ps.live.user_id'       => 'required_if:ps.mode,1',
    'ps.sandbox.password'   => 'required_if:ps.mode,0',
    'ps.live.password'      => 'required_if:ps.mode,1',
    ];
    } else {
    return [
    'status' => 'required',
    ];
    }*/
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "state_id.required_if"                       => __('messages.this_field_is_required'),
            "country_id.required_if"                     => __('messages.this_field_is_required'),
            "title.required_if"                          => __('messages.this_field_is_required'),
            "shipping_charge[shipping_rate].required_if" => __('messages.this_field_is_required'),
            "shipping_charge[store_address].required_if" => __('messages.this_field_is_required'),
        ];
    }
}
