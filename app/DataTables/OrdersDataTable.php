<?php

namespace App\DataTables;

use App\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('created_at', function ($order) {
                return $order->created_at->isoFormat('Do MMMM YYYY');
            })
            ->editColumn('id', function ($order) {
                return "#" . ($order->id);
            })
            ->editColumn('order_status', function ($order) {
                if($order->payment_status){
                    return $order->orderStatus->name;
                }else{
                    return '<span class="text-danger">Failed</span>';
                }

            })
            ->addColumn('name', function ($order) {
                return $order->name;
            })
            ->editColumn('price', function ($order) {
                return setting('currency_symbol') . ($order->price > 0 ? $order->price : '0.00');
            })
            ->addColumn('details_url', function ($order) {
                // return view('admin.order.details_url', compact('order'));
                return route('order.view', ['order' => $order->id]);
            })
            ->addColumn('action', function ($order) {
                // return view('admin.order.details_url', compact('order'));
                if($order->payment_status){
                    return view('admin.order.action', compact('order'));
                }
            })
            ->addColumn('check_box', function ($order) {
                if($order->payment_status){
                    return '<input type="checkbox" class="checkbox" name="order_select" value="'.$order->id.'">';
                }
                return '';
            })
            ->addColumn('products', function($order) {
                return $order->products->pluck('name')->toArray();
            })
            ->rawColumns(['details_url', 'action', 'check_box','order_status'])
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereRaw("CONCAT(billing_first_name,' ',billing_last_name, ' ', billing_address_name, ' ', shipping_address_name) like ?", ["%{$keyword}%"]);
            }, true)
            ->filterColumn('products', function ($query, $keyword) {
                $query->whereHas('products', function($query) use ($keyword) {
                    $query->where("name","like","%".$keyword."%");
                });
            }, true)
            ->filterColumn('price', function ($query, $keyword) {
            }, true);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model, Request $request)
    {
        $orderQuery = $model->newQuery()->with(['orderStatus', 'products'])->select('id', 'billing_first_name', 'billing_last_name', 'order_status_id', \DB::raw('order_total as price'), 'created_at','payment_status');
        if (!empty($request->user_id)) {
            $orderQuery->where('user_id', $request->user_id);
        }
        if (!empty($request->status_id)) {
            $orderQuery->where('order_status_id', $request->status_id);
        }
        if (!empty($request->failed_order) && $request->failed_order=='hide') {
            $orderQuery->active();
        }

        return $orderQuery;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->parameters($this->getBuilderParameters())
            ->minifiedAjax();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'check_box', 'name' => '', 'title' => '<input type="checkbox" id="select_all">', "orderable" => false, "searchable" => false, "className" => 'order-select'],
            ['data' => '', 'name' => '', 'title' => '', "orderable" => false, "searchable" => false, "className" => 'details-control', "defaultContent" => '<i class="icon-plus"  data-toggle="tooltip" data-placement="top" title="View Order Detail">'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => __('messages.date'), 'searchable' => false],
            ['data' => 'id', 'name' => 'id', 'title' => __('messages.order_id'), 'orderable' => true],
            ['data' => 'name', 'name' => 'name', 'title' => __('messages.customer'), 'orderable' => false],
            ['data' => 'price', 'name' => 'price', 'title' => __('messages.price'), 'orderable' => true, 'searchable' => false],
            ['data' => 'order_status', 'name' => 'order_status_id', 'title' => __('messages.status'), 'orderable' => true],
            ['data' => 'products', 'name' => 'products', 'title' => 'Products', 'searchable' => true],
            ['data' => 'action', 'name' => 'action', 'title' => __('messages.action'), 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function getBuilderParameters()
    {
        return [
            "pageLength"    => 50,
            "drawCallback"  => "function() { callback() }",
            "bLengthChange" => true,
            "bAutoWidth"    => false,
            "stateSave"     => true,
            "deferRender"   => true,
            "order"         => [[2, "desc"]],
        ];
    }
}
