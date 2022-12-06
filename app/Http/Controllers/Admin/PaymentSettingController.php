<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\PaymentSettingRequest;
use App\PaymentSetting;
use SEO;
use Session;

class PaymentSettingController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'settings';

    /**
     * Active sidebar sub menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'payment-settings';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['paymentSettings'] = PaymentSetting::get();
    }
    public function index()
    {
        SEO::setTitle(__('messages.payment_settings'));

        return view('admin.payment_setting.index', with(array('paymentSettings' => $this->data['paymentSettings'])));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentSetting  $PaymentSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentSetting $paymentSetting)
    {
        if (empty($paymentSetting) || ($paymentSetting->isFree == 1) || empty($paymentSetting->view) || ($paymentSetting->status == 0)) {
            abort(404);
        }
        // dd($paymentSetting->value);
        SEO::setTitle($paymentSetting->title . '&nbsp' . __('messages.settings'));
        return view('admin.payment_setting.' . $paymentSetting->view, with(['paymentSettings' => $this->data['paymentSettings'], 'paymentSetting' => $paymentSetting]));
    }

    public function update(PaymentSettingRequest $request, PaymentSetting $paymentSetting)
    {
        if ($request->ajax()) {
            try {
                $paymentSetting->update(['status' => $request->input('status')]);
                Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.payment_settings')]));
                return 'success';
            } catch (Exception $e) {
                Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.payment_settings')]));
                return 'fail';
            }
        } else {
            try {
                $paymentSetting->update(['value' => $request->input('ps')]);
                Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.payment_settings')]));
            } catch (Exception $e) {
                Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.payment_settings')]));
            }
            return redirect()->back()->withInput($request->all());
        }
    }
}
