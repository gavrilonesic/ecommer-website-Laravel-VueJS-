<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
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
            'title' => 'required',
        ];
        if (\Request::route()->getName() !== 'video.edit' && \Request::route()->getName() !== 'video.update') {
            $rules['video'] = "required|file|mimetypes:video/webm,video/mpeg,video/mp4,video/quicktime|max:" . ($this->maxSize() * 1024);
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'video.mimetypes' => "Invalid file type.",
            'video.max'       => "Maximum file size to upload is " . $this->maxSize() . " MB.",
        ];
    }

    public function maxSize()
    {
        $postMaxSize   = (int) (str_replace('M', '', ini_get('post_max_size')));
        $uploadMaxSize = (int) (str_replace('M', '', ini_get('upload_max_filesize')));
        if ($postMaxSize >= $uploadMaxSize) {
            $maxSize = $uploadMaxSize;
        } else {
            $maxSize = $postMaxSize;
        }
        return $maxSize;
    }
}
