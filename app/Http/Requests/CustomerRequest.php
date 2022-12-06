<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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

        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'mobile_no' => 'required|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->customer->id ?? 0)->where('is_guest', false)->whereNull('deleted_at'),
            ],
            'customer_address.first_name' => 'sometimes|required|max:255',
            'customer_address.last_name' => 'sometimes|required|max:255',
            'customer_address.address_name' => 'sometimes|required|max:255',
            'customer_address.address_line_1' => 'sometimes|required',
            'customer_address.mobile_no' => 'sometimes|required|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'customer_address.country_id' => 'sometimes|required',
            'customer_address.state_id' => 'sometimes|required',
            // 'customer_address.state_name' => 'sometimes|required',
            'customer_address.city_name' => 'sometimes|required',
            'customer_address.zip_code' => 'sometimes|required',
        ];

        if (!isset($this->customer->id)) {
            $rules['password']         = 'required|max:255';
            $rules['confirm_password'] = 'required|max:255|same:password';
        } else {
            $rules['confirm_password'] = 'max:255|same:password';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'mobile_no.regex' => 'Please enter valid number',
            'customer_address.first_name.required' => 'The first name field is required.',
            'customer_address.last_name.required' => 'The last name field is required.',
            'customer_address.mobile_no.required' => 'The mobile number field is required.',
            'customer_address.address_line_1.required' => 'The address 1 field is required.',
            'customer_address.country_id.required' => 'The country field is required.',
            'customer_address.state_id.required' => 'The state field is required.',
            'customer_address.city_name.required' => 'The city field is required.',
            'customer_address.state_name.required' => 'The state name field is required.',
            'customer_address.zip_code.required' => 'The zip code field is required.',
            'customer_address.mobile_no.regex' => 'Please enter valid mobile no.',
            'customer_address.address_name.required'        => 'The comapny name field is required.',
            'customer_address.address_name.max'        => 'The company name may not be greater than 255 characters.',
        ];
    }
}
