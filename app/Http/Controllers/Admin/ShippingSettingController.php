<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\ShippingSettingRequest;
use App\ShippingSetting;
use App\State;
use Illuminate\Http\Request;
use SEO;
use Session;

class ShippingSettingController extends AdminController
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
    public $activeSidebarSubMenu = 'shipping-settings';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->data['shippingSettings'] = ShippingSetting::get();
    // }
    public function index()
    {
        $shippingZones    = config('constants.SHIPPING_ZONES');
        $shippingSettings = ShippingSetting::get();
        $restOfTheWorld   = ShippingSetting::where('shipping_zone', 2)->get();
        SEO::setTitle(__('messages.shipping_settings'));
        return view('admin.shipping_setting.index', compact('shippingZones', 'shippingSettings', 'restOfTheWorld'));
    }

    /**
     * Show the form for add the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $shippingSetting = config('constants.SHIPPING_ZONES');
        if (empty($request->shippingZone) && empty($shippingSetting[$request->shippingZone])) {
            abort(404);
        } else {
            $shippingSetting = $shippingSetting[$request->shippingZone];
        }

        $countries = Country::pluck('name', 'id');

        return view('admin.shipping_setting.' . $shippingSetting['view'], compact('countries', 'shippingSetting'));
    }

    public function store(ShippingSettingRequest $request)
    {
        try {
            $requestData = $request->all();
            if (empty($requestData['title'])) {
                if ($requestData['shipping_zone'] == 0) {
                    $country              = Country::find($requestData['country_id']);
                    $requestData['title'] = $country->name;
                } else if ($requestData['shipping_zone'] == 1) {
                    $state                = State::find($requestData['state_id']);
                    $requestData['title'] = $state->name;
                }
            }
            $shippingSetting = ShippingSetting::create($requestData);
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.shipping_zone')]));

            return redirect()->route('shipping_settings.edit', ['shippingSetting' => $shippingSetting->id]);
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.shipping_zone')]));

            return redirect()->route('shipping_settings');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShippingSetting  $ShippingSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ShippingSetting $shippingSetting)
    {
        if ($request->ajax()) {
            $shippingQuotes = config('constants.SHIPPING_QUOTES');

            return view('admin.shipping_setting.' . $shippingQuotes[$request->id]['view'], compact('shippingSetting'));
        } else {
            $shippingQuotes = config('constants.SHIPPING_QUOTES');

            return view('admin.shipping_setting.edit', compact('shippingSetting', 'shippingQuotes'));
        }

        if (empty($shippingSetting) || ($shippingSetting->isFree == 1) || empty($shippingSetting->view) || ($shippingSetting->status == 0)) {
            abort(404);
        }
        // dd($shippingSetting->value);
        SEO::setTitle($shippingSetting->title . '&nbsp' . __('messages.settings'));
        return view('admin.shipping_setting.' . $shippingSetting->view, with(['shippingSettings' => $this->data['shippingSettings'], 'shippingSetting' => $shippingSetting]));
    }

    public function update(Request $request, ShippingSetting $shippingSetting)
    {
        if ($request->ajax()) {
            try {
                $value = !empty($shippingSetting->value) ? $shippingSetting->value : new \stdClass();
                $id    = $request->id;
                if (isset($request->shipping_charge['is_enabled']) && $request->shipping_charge['is_enabled'] == 0) {
                    if (is_object($value->$id) && isset($value->$id->is_enabled)) {
                        $value->$id->is_enabled = 0;
                    }
                } else {
                    $value->$id = $request->shipping_charge;
                }
                $shippingSetting->update(['value' => $value]);
                Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.shipping_settings')]));
                return 'success';
            } catch (Exception $e) {
                Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.shipping_settings')]));
                return 'fail';
            }
        } else {
            try {
                $shippingSetting->update(['value' => $request->input('ps')]);
                Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.shipping_settings')]));
            } catch (Exception $e) {
                Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.shipping_settings')]));
            }
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy(ShippingSetting $shippingSetting)
    {
        try {
            $shippingSetting->delete();
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.shipping_settings')]));
            return redirect()->route('shipping_settings');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.shipping_settings')]));
            return redirect()->route('shipping_settings');

        }
    }

    /**
     * change Shipping Zone status.
     *
     * @param  \App\ShippingSetting  $shippingSetting
     * @return \Illuminate\Http\Response
     */
    public function status(ShippingSetting $shippingSetting)
    {
        try {
            if ($shippingSetting->status == config('constants.STATUS.STATUS_ACTIVE')) {
                $shippingSetting->status = config('constants.STATUS.STATUS_INACTIVE');
            } else {
                $shippingSetting->status = config('constants.STATUS.STATUS_ACTIVE');
            }
            Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.shipping_zone')]));
            $shippingSetting->save();

            return redirect()->route('shipping_settings');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_status_not_updated_error_msg', ['name' => __('messages.shipping_zone')]));

            return redirect()->route('shipping_settings');
        }
    }
}
