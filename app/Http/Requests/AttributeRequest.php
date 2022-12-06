<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttributeRequest extends FormRequest
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
            'name'           => [
                'required',
                'max:255',
                Rule::unique('attributes')->ignore($this->attribute->id ?? 0)->whereNull('deleted_at'),
            ],
            'attribute_type' => 'required',
        ];
        if (Request::isMethod('get')) {
            $rules['attribute_options[0][option]'] = 'required';
        } else {
            $rules['attribute_options.0.option'] = 'required';
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
            'attribute_options.0.option.required'   => __('messages.this_option_field_is_required'),
            'attribute_options[0][option].required' => __('messages.this_option_field_is_required'),
        ];
    }
}
