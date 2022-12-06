<?php

namespace App\Http\Controllers\Admin;

use App\Contactform;
use App\Http\Controllers\Admin\AdminController;
use Exception;
use Illuminate\Http\Request;
use Session;

class ContactFormController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'storefront';

    /**
     * Active sidebar sub menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'contactforms';

    public function contactformlist()
    {
        $contactlist = Contactform::orderBy('created_at', 'DESC')->get();
        return view('admin.contactform.index', compact('contactlist'));
    }

    public function deletecontactentry(Request $request, Contactform $contactform)
    {
        try {
            $contactform->delete();
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.contact_information')]));
            return redirect()->route('contactform.index');

        } catch (Exception $e) {

            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.contact_information')]));
            return redirect()->route('contactform.index');

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contactform  $contactform
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contactform $contactform)
    {
        try {
            if ($contactform->status == 0) {
                Contactform::where('id', $contactform->id)->update(['status' => 1]);
            } else {
                Contactform::where('id', $contactform->id)->update(['status' => 0]);
            }
            Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.contactform')]));
            return redirect()->route('contactform.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.contactform')]));
            return redirect()->back()->withInput($request->all());
        }
    }

}
