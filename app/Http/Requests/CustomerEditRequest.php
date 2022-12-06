<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerEditRequest extends FormRequest
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
                Rule::unique('users')->ignore($this->customer->id ?? 0)->whereNull('deleted_at')
            ],
        ];

        if (!isset($this->customer->id)) {
            $rules['password'] = 'required|max:255';
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
            'mobile_no.regex' => 'Please enter valid number.',
        ];
    }
}
