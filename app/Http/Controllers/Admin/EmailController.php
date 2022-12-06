<?php

namespace App\Http\Controllers\Admin;

use App\Email;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Mail;
use Session;

class EmailController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $activeSidebarMenu    = 'storefront';
    public $activeSidebarSubMenu = 'emails';

    public function index()
    {
        $emails = Email::getEmails();
        // dd($emails);
        return view('admin.email.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit($emailId)
    {
        if (!isset(Email::$emails[$emailId])) {
            abort(404);
        }
        $email           = Email::getEmail($emailId);
        $email['header'] = "";
        $email['footer'] = "";

        if (!empty($email['body'])) {
            $bodyContent  = Email::getEmail($email['body'])['content'];
            $bodySections = explode('[Main Content]', $bodyContent);
            if (count($bodySections) == 2) {
                $email['header'] = $bodySections[0];
                $email['footer'] = $bodySections[1];
            }
        }
        // dd($email);
        return view('admin.email.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update($emailId, Request $request)
    {
        if (!isset(Email::$emails[$emailId])) {
            abort(404);
        }
        $fromDB      = Email::where('title', $emailId)->first();
        $requestData = $request->all();
        if ($fromDB) {
            $fromDB->update($requestData);
        } else {
            $values          = $request->all();
            $values['title'] = $emailId;
            $new             = Email::create($values);
        }
        Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.emails')]));
        return redirect()->route('email.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy($emailId)
    {
        $fromDB = Email::where('title', $emailId)->first();
        if ($fromDB) {
            try {
                $fromDB->delete();
                Session::flash('success', __('messages.record_restored_success_msg', ['name' => __('messages.emails')]));
                return redirect()->route('email.index');

            } catch (Exception $e) {
                Session::flash('error', __('messages.record_restored_success_msg', ['name' => __('messages.emails')]));
                return redirect()->route('email.index');

            }
        }

    }

    public function sendTest($emailId)
    {
        if (!isset(Email::$emails[$emailId])) {
            return "Wrong Request";
        }
        $notificationEmail = setting('admin_notification_email');
        if (empty($notificationEmail)) {
            Session::flash('error', __('messages.notification_email_not_set'));
            return redirect()->route('email.index');
        }
        try {
            Email::sendEmail($emailId, [], $notificationEmail);
        } catch (\Exception $e) {
            logger($e->getMessage());
            Session::flash('error', __('messages.test_email_not_sent_sucessfully', ['email' => $notificationEmail]));
            return redirect()->route('email.index');
        }
    }
}
