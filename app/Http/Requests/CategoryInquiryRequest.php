<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryInquiryRequest extends FormRequest
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
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email',
            'phone' => 'required|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'street_address' => 'required|max:50',
            'g-recaptcha-response' => 'required|recaptchav3:first_name,0.5',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
            'zipcode' => 'required|max:50',
            'country' => 'required|max:50',
        ];
    }
}
