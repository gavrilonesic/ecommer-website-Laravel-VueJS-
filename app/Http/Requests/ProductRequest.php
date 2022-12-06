<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name'     => 'required|max:255',
            'sku'      => 'required',
            //'product_type' => 'required',
            'price'    => 'required',
            'brand_id' => 'required',
            'weight'   => 'required',
        ];

        if (Request::isMethod('get')) {
            $rules['category_id[]'] = 'required';
        } else {
            $rules['category_id'] = 'required';
        }
        if (\Request::route()->getName() == 'product.edit' || \Request::route()->getName() == 'product.update') {
            if (isset($this->product->id)) {
                $id = $this->product->id;
            } else {
                $id = $this->product;
            }
            $rules['slug'] = [
                'required',
                Rule::unique('products')->ignore($this->product->id ?? 0)->whereNull('deleted_at'),
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
            "category_id[].required" => __('messages.this_category_field_is_required'),
            "category_id.required"   => __('messages.this_category_field_is_required'),
        ];
    }
}
