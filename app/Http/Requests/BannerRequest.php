<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BannerRequest extends FormRequest
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
            'name'              => 'required',
            'link'              => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'type'              => 'required',
            'image'             => 'required_if:image_exists,null',
            'category'          => 'required_if:show_on_page,for_specific_category',
            'brand'             => 'required_if:show_on_page,for_specific_brand',
            'show_on_page'      => 'required',
            'date_range_option' => 'required',
            'date_start'        => 'required_if:date_range_option,0',
            'date_end'          => 'required_if:date_range_option,0',
            //'visibility' => 'required'
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
            'link.regex'             => 'Link/URL only allowed. e.g https://yourdomain.com/image.png',
            'date_start.required_if' => 'Date is required!',
            'date_end.required_if'   => 'Date is required!',
            'image_exists.required'  => 'The image field is required',
            'image.required_if'      => 'The image field is required',
        ];
    }

}
