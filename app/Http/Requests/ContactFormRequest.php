<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
            'name' => 'required|max:50',
            'email' => 'required|email',
            'telephone' => 'required|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'g-recaptcha-response' => 'required|recaptchav3:name,0.5',
            'comments' => 'required'
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
            'telephone.regex' => 'Please enter valid Mobile number.',
            'telephone.required' => 'The Mobile number field is required.',
            'comments.required' => 'The description field is required.',
        ];
    }

}
