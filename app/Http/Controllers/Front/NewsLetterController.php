<?php

namespace App\Http\Controllers\Front;

use App\Email;
use App\Http\Controllers\Front\FrontController;
use App\Http\Requests\NewsletterRequest;
use Newsletter;

class NewsLetterController extends FrontController
{
    /**
     * Handle a newsletter request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(NewsletterRequest $request)
    {
        if ($request->ajax()) {
            config(['newsletter.apiKey' => setting('mail_chimp_api_key')]);
            config(['newsletter.lists.subscribers.id' => setting('mail_chimp_list_id')]);

            if (!Newsletter::isSubscribed($request->email)) {
                if (Newsletter::subscribeOrUpdate($request->email)) {
                    $placeHolders = [
                        '[Customer Email]' => $request->email,
                    ];
                    Email::sendEmail('customer.newsletter', $placeHolders, $request->email);
                    return response()->json([
                        "status"  => 'success',
                        "type"    => 'success',
                        "message" => __('messages.email_successfully_added_to_newsletter'),
                    ]);
                } else {
                    return response()->json([
                        "status"  => 'error',
                        "type"    => 'error',
                        "message" => Newsletter::getLastError(),
                    ]);
                }
            } else {
                return response()->json([
                    "status"  => 'success',
                    "type"    => 'success',
                    "message" => __('messages.email_already_added_to_newsletter'),
                ]);
            }
        }

    }
}
