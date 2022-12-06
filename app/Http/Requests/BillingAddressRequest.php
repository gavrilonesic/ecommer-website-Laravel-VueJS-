<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class BillingAddressRequest extends FormRequest
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
            'billing_address_id' => 'required_if:billing_address_option,0',
            'first_name'         => 'required_if:billing_address_option,1|max:255',
            'last_name'          => 'required_if:billing_address_option,1|max:255',
            'address_name'          => 'required_if:billing_address_option,1|max:255',
            //'mobile_no' => 'required_if:address_option,1|regex:/[0-9]{10}/|min:10',
            'mobile_no' => 'required_if:billing_address_option,1|sometimes|nullable|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'email' => [
                'required_if:billing_address_option,1',
                'sometimes',
                'nullable',
                'email',
                'max:255',
            ],
            'address_line_1'     => 'required_if:billing_address_option,1|max:255',
            //'address_line_2' => 'required_if:address_option,1|max:255',
            'country_id' => 'required_if:billing_address_option,1|max:255',
            'state_id' => 'required_if:billing_address_option,1|max:255|sometimes',
            // 'state_name' => 'required_if:billing_address_option,1|max:255|sometimes',
            'city_name' => 'required_if:billing_address_option,1|max:255',
            'zip_code' => 'required_if:billing_address_option,1|max:255',
        ];

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
            'billing_address_id.required_if'        => 'Please select address',
            'address_name.required_if'        => 'The comapny name field is required.',
            'address_name.max'        => 'The company name may not be greater than 255 characters.',
            'first_name.required_if'     => 'The first name field is required.',
            'last_name.required_if'      => 'The last name field is required.',
            'mobile_no.required_if'      => 'The mobile number field is required.',
            'email.required_if'          => 'The email field is required.',
            'address_line_1.required_if' => 'The address 1 field is required.',
            'country_id.required_if' => 'The country field is required.',
            'state_id.required_if' => 'The state field is required.',
            'state_name.required_if' => 'The state name field is required.',
            'city_name.required_if' => 'The city field is required.',
            'zip_code.required_if' => 'The zip code field is required.',
            'mobile_no.regex' => 'Please enter valid mobile no.',
        ];
    }
}
