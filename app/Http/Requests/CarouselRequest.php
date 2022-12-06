<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarouselRequest extends FormRequest
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
            // 'heading'          => 'required',
            // 'button_text'      => 'required',
            'link'             => 'nullable|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            // 'image'            => 'required_if:image_exists,null',
            'background_image' => 'required_if:imagebg_exists,null',
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
            'link.regex'                   => 'Link/URL only allowed. e.g https://yourdomain.com/',
            'image_exists.required'        => 'The image field is required',
            'image.required_if'            => 'The image field is required',
            'imagebg_exists.required'      => 'The image field is required',
            'background_image.required_if' => 'The image field is required',
        ];
    }

}
