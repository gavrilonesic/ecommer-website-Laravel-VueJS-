<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PaymentSettingRequest extends FormRequest
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
        if (((Request::input('method') == 'authorizenet') && (Request::isMethod('put'))) || (Request::isMethod('get'))) {
            return [
                'ps.mode'                    => 'required',
                'ps.sandbox.login_id'        => 'required_if:ps.mode,0',
                'ps.live.login_id'           => 'required_if:ps.mode,1',
                'ps.sandbox.transaction_key' => 'required_if:ps.mode,0',
                'ps.live.transaction_key'    => 'required_if:ps.mode,1',
            ];
        } else {
            return [
                'status' => 'required',
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "ps.sandbox.*.required_if" => __('messages.this_field_is_required_sandbox'),
            "ps.live.*.required_if"    => __('messages.this_field_is_required_live'),
        ];
    }
}
