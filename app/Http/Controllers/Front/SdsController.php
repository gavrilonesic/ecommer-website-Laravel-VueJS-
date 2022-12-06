<?php

namespace App\Http\Controllers\Front;

use App\Email;
use App\Http\Controllers\Front\FrontController;
use App\Http\Requests\SdsFormRequest;
use App\Product;
use App\Sds;
use Exception;

class SdsController extends FrontController
{
    public function index()
    {
        return view('front.sds.index');
    }
    public function store(SdsFormRequest $request)
    {
        try {
            $data         = $request->all();
            $data['ip']   = \Request::ip();
            $sds          = Sds::create($data);
            $placeHolders = [
                '[Customer Name]'      => $sds->name ?? '',
                '[Company Name]'       => $sds->company_name ?? '',
                '[Customer Email]'     => $sds->email ?? '',
                '[Customer Telephone]' => $sds->telephone ?? '',
                '[Website]'            => $sds->website ?? '',
                '[Product]'            => $sds->product ?? '',
                '[Sds Username]'       => setting('sds_user_name') ?? '',
                '[Sds Password]'       => setting('sds_password') ?? '',
                '[Sds Email]'          => setting('sds_email') ?? '',
                '[Sds Link]'           => setting('sds_link') ?? '',
            ];
            // Email to Admin
            if (!empty(setting('sds_notification_email'))) {
                Email::sendEmail('admin.sds', $placeHolders, setting('sds_notification_email'));
            }
            Email::sendEmail('customer.sds', $placeHolders, $sds->email ?? '');

            return redirect()->route('sds')->with('success', __('messages.record_add_successfull_msg', ['name' => __('messages.sds_submission')]));

        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error', __('messages.record_add_error_msg', ['name' => __('messages.sds_submission')]));
        }

    }

}
