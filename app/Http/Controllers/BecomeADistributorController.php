<?php

namespace App\Http\Controllers;

use App\Email;
use App\Http\Requests\BecomeADistributorFormRequest;

class BecomeADistributorController extends Controller
{
    public function index()
    {
        return view('front.become-a-distributor.index');
    }

    public function store(BecomeADistributorFormRequest $request)
    {
        try {
            $placeHolders = [
                '[Name]'      => $request->name,
                '[Email]'     => $request->email,
                '[Company Name]'     => $request->company_name ?? '',
                '[State]' => $request->state ?? '',
                '[Phone]' => $request->phone,
                '[Product Interest]'   => $request->product_interest ?? '',
            ];
            Email::sendEmail('admin.become-a-distributor', $placeHolders, setting('contact_notification_email'));

            return redirect()->route('become_a_distributor.index')->with('success', __('messages.record_add_successfull_msg', ['name' => __('messages.contact_submission')]));

        } catch (Exception $e) {
            report($e);
            Log::info(json_encode($request->all()));
            return redirect()->back()->withInput($request->all())->with('error', __('messages.record_add_error_msg', ['name' => __('messages.contact_submission')]));
        }
    }
}
