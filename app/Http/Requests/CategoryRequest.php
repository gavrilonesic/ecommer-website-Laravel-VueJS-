<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'name'      => [
                'required',
                'max:255',
                // Rule::unique('categories')->ignore($this->category->id ?? 0)->whereNull('deleted_at')
            ],
            'parent_id' => 'integer|required',
        ];
        if (\Request::route()->getName() == 'category.edit' || \Request::route()->getName() == 'category.update') {
            if (isset($this->category->id)) {
                $id = $this->category->id;
            } else {
                $id = $this->category;
            }
            $rules['slug'] = [
                'required',
                Rule::unique('categories')->ignore($this->category->id ?? 0)->whereNull('deleted_at'),
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
            'parent_id.required' => 'Please select one child type',
        ];
    }
}
