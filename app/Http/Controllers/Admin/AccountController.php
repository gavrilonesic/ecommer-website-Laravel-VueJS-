<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\AdminChangePasswordRequest;
use App\Http\Requests\AdminRequest;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\Request;
use SEO;
use Session;

class AccountController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'dashboards';

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        SEO::setTitle(__('messages.edit_admin'));

        return view('admin.auth.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request)
    {
        try {
            $admin = Auth::guard('admin')->user();
            $admin->update($request->all());

            if (!empty($request->image)) {
                try {
                    $mediaItems = $admin->getMedia('admin');
                    $admin->addMediaFromRequest('image')->toMediaCollection('admin', 'admins');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {
                    Session::flash('error', __("messages.image_not_update"));

                    return redirect()->route('admin.edit');
                }
            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.admin')]));

            return redirect()->route('admin.edit');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.admin')]));

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
    public function changePassword(AdminChangePasswordRequest $request)
    {
        try {
            $admin = Auth::guard('admin')->user();
            if (Hash::check($request->current_password, Auth::guard('admin')->user()->password)) {
                $admin->password = Hash::make($request->new_password);
                if ($admin->save()) {
                    Session::flash('success', __('messages.password_updated_successfully'));
                }
            } else {
                Session::flash('error', __('messages.current_password_not_matched'));
            }

            return redirect()->route('admin.edit');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg'));

            return redirect()->back()->withInput($request->all());
        }
    }
}
