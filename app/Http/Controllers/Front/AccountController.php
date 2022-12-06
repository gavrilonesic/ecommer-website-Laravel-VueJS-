<?php

namespace App\Http\Controllers\Front;

use App\Country;
use App\Email;
use App\Http\Controllers\Front\FrontController;
use App\Http\Requests\AddressRequest;
use App\Order;
use App\User;
use App\UserAddress;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\Request;
use PDF;
use Session;

class AccountController extends FrontController
{
    /**
     * Showing customer profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function myProfile()
    {
        return view('front.account.myaccount');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();
            if ($user->update($request->all())) {
                Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.user')]));

                return redirect()->route('my_profile');
            }
            Session::flash('error', __('messages.record_updated_success_msg', ['name' => __('messages.user')]));

            return redirect()->route('my_profile');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.user')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Update admin password
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();

            if (Hash::check($request->current_password, Auth::guard('web')->user()->password)) {
                $user->password = Hash::make($request->new_password);
                if ($user->save()) {
                    $placeHolders = [
                        '[Customer Name]' => $user->name ?? '',
                    ];
                    Email::sendEmail('customer.change_password', $placeHolders, $user->email ?? '');

                    Session::flash('success', __('messages.password_updated_successfully'));
                }
            } else {
                Session::flash('error', __('messages.current_password_not_matched'));
            }
            return redirect()->route('my_profile');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.change_password')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    public function myaddresses()
    {
        $userid = Auth::guard('web')->user()->id;
        if (empty($userid)) {$userid = '';}
        $user = User::with(['userAddress', 'userAddress.state', 'userAddress.country'])->where('id', $userid)->orderBy('created_at', 'DESC')->firstorFail();

        return view('front.account.myaccount', compact('user'));
    }

    public function address_add()
    {
        $countries = Country::pluck('name', 'id');
        $userid    = Auth::guard('web')->user()->id;
        return view('front.account.addressadd', compact('countries', 'userid'));
    }

    public function address_save(UserAddress $address, AddressRequest $request)
    {
        try {
            $request->merge(['user_id' => Auth::guard('web')->user()->id]);
            $address = UserAddress::create($request->all());
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.address')]));
            return redirect()->route('my_addresses');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.address')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    public function address_edit($id)
    {
        $countries = Country::pluck('name', 'id');
        $userid    = Auth::guard('web')->user()->id;
        $customers = UserAddress::with(['state', 'country'])->where('id', $id)->where('user_id', $userid)->orderBy('id', 'DESC')->firstOrFail();
        return view('front.account.addressedit', compact('countries', 'customers'));
    }

    public function address_update(UserAddress $address, AddressRequest $request)
    {

        try {
            $request->request->remove('user_id');
            $address->update($request->all());
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.address')]));
            return redirect()->route('my_addresses');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.address')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    public function address_delete(UserAddress $address)
    {
        try {
            $address->delete();
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.address')]));

            return redirect()->route('my_addresses');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.address')]));

            return redirect()->route('my_addresses');
        }
    }

    public function uploadimage(Request $request)
    {
        if ($_FILES["file"]["name"] != '') {
            try {
                $mediaItems = Auth::guard('web')->user()->getMedia('profilepic');
                Auth::guard('web')->user()->addMediaFromRequest('file')->toMediaCollection('profilepic', 'profilepics');
                if ($mediaItems->count() > 0) {
                    $mediaItems[0]->delete();
                }
            } catch (Exception $e) {
                Session::flash('error', __("messages.image_not_update"));
                return redirect()->route('my-profile');
            }
            return '1';
        }
    }

    public function view_invoice($id)
    {
        try {

            if (!empty($id)) {
                $order = Order::with(['orderItems' => function ($query) {
                    $query->with(['product' => function ($query) {
                        $query->select('id', 'name', 'brand_id')->with(['brand', 'medias' => function ($query) {
                            $query->whereJsonContains('custom_properties->default_image', true);
                        }]);
                    }])->orderBy('id', 'DESC');
                }])->where('id', $id)->where('user_id', Auth::guard('web')->user()->id)->orderBy('id', 'DESC')->firstOrFail();
                if (!empty($order->id)) {
                    $file = "Invoice_" . $order->id . ".pdf";
                } else {
                    $file = "Invoice.pdf";
                }

            } else {
                $order = array();
            }
            $pdf = PDF::loadView('front.order.invoice', compact('order'));
            return $pdf->download($file);

        } catch (DOMPDF_Exception $e) {

        }
    }

}
