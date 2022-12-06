<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SdsFormRequest extends FormRequest
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
            'name'         => 'required|max:50',
            'company_name' => 'required|max:255',
            'g-recaptcha-response' => 'required|recaptchav3:name,0.5',
            'telephone' => 'required|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'email' => 'required|email',
            'product' => 'required',
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
            'telephone.regex' => 'Please enter valid telephone.'
        ];
    }

}
