<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CouponRequest extends FormRequest
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
            'name'             => 'required',
            'code'             => 'required|regex:/^[A-Za-z0-9-]+$/',
            'price_type'       => 'required',
            'price'            => 'required_if:price_type,flat_price|numeric',
            'percentage_value' => 'required_if:price_type,percentage|numeric|max:100',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.regex' => 'Characters & numbers only, no spaces, no special characters.',
        ];
    }

}
