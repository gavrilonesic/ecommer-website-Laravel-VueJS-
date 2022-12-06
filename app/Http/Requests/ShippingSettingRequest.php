<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ShippingSettingRequest extends FormRequest
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
        return [
            'country_id' => 'required_if:shipping_zone,0|required_if:shipping_zone,1',
            'state_id'   => 'required_if:shipping_zone,1',
            'title'      => 'required_if:shipping_zone,2',
        ];

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
            "state_id.required_if"   => __('messages.this_field_is_required'),
            "country_id.required_if" => __('messages.this_field_is_required'),
            "title.required_if"      => __('messages.this_field_is_required'),
        ];
    }
}
