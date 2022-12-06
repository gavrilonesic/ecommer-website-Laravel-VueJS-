<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'first_name'       => 'required|max:255',
            'last_name'        => 'required|max:255',
            'email'            => ['required', 'email', 'max:255',
                Rule::unique('admins')->ignore($this->user->id ?? 0)->whereNull('deleted_at'),
            ],
            'mobile_no' => 'sometimes|nullable|regex:/^(?=.*[0-9])[- +()0-9]+$/',
            'password'         => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
        ];
    }
}
