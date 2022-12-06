<?php

namespace App\Http\Controllers\Front;

use App\Contactform;
use App\Email;
use App\Http\Controllers\Front\FrontController;
use App\Http\Requests\ContactFormRequest;
use App\Inspections\Spam;
use Exception;
use Log;

class ContactController extends FrontController
{
    public function index()
    {
        return view('front.contact.index');
    }

    public function store(ContactFormRequest $request)
    {
        try {
            resolve(Spam::class)->detect($request->input('comments'));
            resolve(Spam::class)->detect($request->input('name'));
            $data         = $request->all();
            $data['ip']   = \Request::ip();
            $contact      = Contactform::create($data);
            $placeHolders = [
                '[Customer Name]'      => $contact->name ?? '',
                '[Customer Email]'     => $contact->email ?? '',
                '[Customer Telephone]' => $contact->telephone ?? '',
                '[Customer Comment]'   => $contact->comments ?? '',
            ];

            // Email to Admin
            if (! empty(setting('contact_notification_email'))) {
                Email::sendEmail('admin.contact', $placeHolders, setting('contact_notification_email'));
            }

            Email::sendEmail('customer.contact', $placeHolders, $contact->email ?? '');

            return redirect()->route('contact_us')->with('success', __('messages.record_add_successfull_msg', ['name' => __('messages.contact_submission')]));

        } catch (Exception $e) {
            report($e);
            Log::info(json_encode($request->all()));
            return redirect()->back()->withInput($request->all())->with('error', __('messages.record_add_error_msg', ['name' => __('messages.contact_submission')]));
        }

    }

}
