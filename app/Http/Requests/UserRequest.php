<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name'    => 'required|max:255',
            'email'   => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($this->user->id ?? 0)->whereNull('deleted_at'),
            ],
            'role_id' => 'required',
        ];
        if (!isset($this->user->id)) {
            $rules['password']         = 'required|min:8';
            $rules['confirm_password'] = 'required|min:8|same:password';
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

        ];
    }
}
