<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'first_name'     => 'required|max:255',
            'last_name'      => 'required|max:255',
            'address_name'      => 'required|max:255',
            'address_line_1' => 'required|max:255|pobox:address_line_1,address_line_2',
            'mobile_no' => 'required|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'country_id' => 'required|max:255',
            'state_id' => 'sometimes|required|max:255',
            // 'state_name' => 'sometimes|required|max:255',
            'city_name' => 'required|max:255',
            'zip_code' => 'required|max:255',
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
            'first_name.required'     => 'The first name field is required.',
            'last_name.required'      => 'The last name field is required.',
            'address_name.required'      => 'The comapny name field is required.',
            'address_name.max'        => 'The company name may not be greater than 255 characters.',
            'mobile_no.required'      => 'The mobile number field is required.',
            'address_line_1.required' => 'The address 1 field is required.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
            'city_name.required' => 'The city field is required.',
            'zip_code.required' => 'The zip code field is required.',
            'mobile_no.regex' => 'Please enter valid mobile no.',
        ];
    }
}
