<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\ClientRequest;
use App\Client;
use Exception;
use File;
use Illuminate\Http\Request;
use SEO;
use Session;
use Spatie\MediaLibrary\Models\Media;

class ClientController extends AdminController
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
    public $activeSidebarSubMenu = 'clients';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.clients'));

        $clients = Client::all();

        return view('admin.client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_client'));

        return view('admin.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        try {
            $client = Client::create($request->all());

            if (!empty($request->image)) {
                $client->addMediaFromRequest('image')->toMediaCollection('clients');
            }

            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.client')]));

            return redirect()->route('client.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.client')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        SEO::setTitle(__('messages.edit_client'));

        return view('admin.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        try {
            if ($request->changestatus == 1) {
                Client::where('id', $client->id)->update(['active' => 0]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.client')]));
                return redirect()->route('client.index');
            } else if (isset($request->changestatus) && $request->changestatus == 0) {
                Client::where('id', $client->id)->update(['active' => 1]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.coupon')]));
                return redirect()->route('client.index');
            }
            $client->update($request->all());
            if (!empty($request->image)) {
                try {
                    $mediaItems = $client->getMedia('clients');
                    $client->addMediaFromRequest('image')->toMediaCollection('clients');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {
                    Session::flash('error', __("messages.image_not_update"));

                    return redirect()->route('client.index');
                }
            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.client')]));

            return redirect()->route('client.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.client')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        try {
            $client->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.client')]));

            return redirect()->route('client.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.client')]));

            return redirect()->route('client.index');
        }
    }

    //deletes image from edit page if user wants to
    public function deleteimage(Client $client, Request $request)
    {
        try {
            $mediaItems = $client->getMedia('clients');
            if ($mediaItems->count() > 0) {
                $mediaItems[0]->delete();
            }
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.image')]));
            return '1';
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.image')]));
            return '0';
        }
    }

}
