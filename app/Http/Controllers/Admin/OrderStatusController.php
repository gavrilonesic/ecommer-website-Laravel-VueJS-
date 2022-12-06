<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\OrderStatusRequest;
use App\OrderStatus;
use Exception;
use Illuminate\Http\Request;
use SEO;
use Session;

class OrderStatusController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'orders';

    /**
     * Active sidebar sub menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'orderStatus';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.order_status'));

        $orderStatus = OrderStatus::orderBy('id', 'DESC')->get();

        return view('admin.order_status.index', compact('orderStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_order_status'));

        return view('admin.order_status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStatusRequest $request)
    {
        try {
            $orderStatus = OrderStatus::create($request->all());

            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.order_status')]));

            return redirect()->route('order_status.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.order_status')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function show(OrderStatus $orderStatus)
    {
        SEO::setTitle(__('messages.view_order_status'));

        return view('admin.order_status.show', compact('orderStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderStatus $orderStatus)
    {
        SEO::setTitle(__('messages.edit_order_status'));

        return view('admin.order_status.edit', compact('orderStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function update(OrderStatusRequest $request, OrderStatus $orderStatus)
    {
        try {
            $orderStatus->update($request->all());

            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.order_status')]));

            return redirect()->route('order_status.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.order_status')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderStatus  $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderStatus $orderStatus)
    {
        try {
            $orderStatus->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.order_status')]));

            return redirect()->route('order_status.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.order_status')]));

            return redirect()->route('order_status.index');
        }
    }
}
