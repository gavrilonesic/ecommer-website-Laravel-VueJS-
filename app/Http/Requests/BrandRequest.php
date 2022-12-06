<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
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
            'name' => 'required|max:255',
        ];
        if (\Request::route()->getName() == 'brand.edit' || \Request::route()->getName() == 'brand.update') {
            $rules['slug'] = [
                'required',
                Rule::unique('brands')->ignore($this->brand->id ?? 0)->whereNull('deleted_at'),
                'regex:/^[a-z0-9\-]+$/',
            ];
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
