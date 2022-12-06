<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrdersDataTable;
use App\Email;
use App\Http\Controllers\Admin\AdminController;
use App\Order;
use App\OrderItem;
use App\OrderStatus;
use App\OrderStatusHistory;
use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Http\Request;
use PDF;
use SEO;
use Session;
use DB;
use Illuminate\Validation\Rule;

class OrderController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var OrderRepository
     */
    protected $orderRepository;

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
    public $activeSidebarSubMenu = 'orders';


    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrdersDataTable $dataTable)
    {
        SEO::setTitle(__('messages.orders'));

        $orderStatus = OrderStatus::whereIn('name', [
            'Awaiting Fulfillment', 'Shipped', 'Completed', 'Declined/cancelled'
        ])->orderBy('id', 'asc')->get();

        // $orders = OrderItem::with(['orderStatus', 'product:id,name', 'order:id,first_name,last_name'])->orderBy('id', 'DESC')->get();
        // $orderStatus = OrderStatus::pluck('name', 'id');
        return $dataTable->render('admin.order.index', compact('orderStatus'));
        //return view('admin.order.index', compact('orders', 'orderStatus'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $orderStatus = OrderStatus::pluck('name', 'id');
        $order       = Order::with(['orderItems' => function ($query) {
            $query->with(['product' => function ($query) {
                $query->select('id', 'name', 'slug');
            }, 'orderStatus']);
        }])->findorfail($id);
        return view('admin.order.details', compact('order', 'orderStatus'));
    }

    /**
     * change order status.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, Order $order)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        if ($request->isMethod('get')) {
            $orderStatus = OrderStatus::pluck('name', 'id');

            $order  = $order->load(['orderItems' => function ($query) {
                $query->with(['product' => function ($query) {
                    $query->select('id', 'name');
                }, 'orderStatus']);
            }]);

            return view('admin.order.status', compact('order', 'orderStatus'));
        } elseif ($request->isMethod('post')) {
            try {
                if (!empty($request->order_items) && $request->order_status_id) {

                    $this->orderRepository->changeStatus($order, $request->order_status_id, $request->order_items, $request->all());

                    return response()->json([
                        'message' => __('messages.record_status_updated_success_msg', ['name' => __('messages.order')]),
                    ], 200);
                }
            } catch (Exception $e) {
                dd($e->getMessage());
                return response(__('messages.record_status_not_updated_error_msg', ['name' => __('messages.order')]), 501);
            }
        } else {
            abort(404);
        }
    }

    /**
     * change order status.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function orderCancel(Request $request)
    {
        $order = OrderItem::with(['product:id,name'])->find($request->order_id);

        return view('admin.order.cancel_order', compact('order'));
    }
    public function destroy(Order $order)
    {
        if (!config('constants.ORDER_DELETE')) {
            abort(404);
        }
        try {
            $order->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.order')]));

            return redirect()->route('order.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.order')]));

            return redirect()->route('order.index');
        }
    }

    public function invoice(Request $request, $type)
    {
        if (empty($type) || empty($request->order_id)) {
            abort(404);
        }
        try {
            $orderIds = $request->order_id;
            $orderString = implode('","', $orderIds);
            $orders   = Order::with(['orderItems'])->whereIn('id', $orderIds)->orderByRaw(DB::raw('FIELD(id, ".' . $orderString . '")'))->get();
            if ($type == 'print') {
                return view('admin.order.invoice', compact('orders', 'type'));
            } elseif ($type == 'download') {
                $pdf = PDF::loadView('admin.order.invoice', compact('orders', 'type'));
                if (count($orderIds) == 1) {
                    $file =  "Invoice_" . $orderIds[0] . ".pdf";
                } else {
                    $file = "Invoice.pdf";
                }

                return $pdf->download($file);
            } else {
                abort(404);
            }
        } catch (DOMPDF_Exception $e) {
            return $e->getMessage();
        }
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:orders,id',
            'orders.*.tracking_number' => 'nullable|string',
            'order_status_id' => 'exists:order_status,id',
            'order_send_email' => 'nullable|boolean',
            'tracking_provider_id' => ['nullable', Rule::in(array_keys(config('constants.SHIPPING_PROVIDERS')))],
            'comment' => 'nullable|string',
            'carrier_name' => 'nullable|string',
        ]);

        $orders = Order::whereIn('id', array_column($request->orders, 'id'))->with('orderItems.product')->get()->keyBy('id');

        if ($request->isMethod('get')) {
            $orderStatus = OrderStatus::whereIn('name', [
                'Awaiting Fulfillment', 'Shipped', 'Completed', 'Declined/cancelled'
            ])->orderBy('id', 'asc')->get();
            
            return view('admin.order.bulk', compact('orders', 'orderStatus'));
        }

        try {
            $data = [
                'order_send_email' => $request->order_send_email,
                'order_status_id' => $request->order_status_id,
                'comment' => $request->comment,
                'carrier_name' => $request->carrier_name,
                'tracking_provider_id' => $request->tracking_provider_id,
            ];

            if ($order_status_id = $request->order_status_id) {
                foreach ($request->orders as $rq) {
                    if ($order = $orders->get($rq['id'])) {
                        $data['tracking_number'] = $rq['tracking_number'] ?? '';
                        $this->orderRepository->changeStatus($order, $order_status_id, $order->orderItems->pluck('id')->toArray(), $data, true);
                    }
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('messages.record_status_not_updated_error_msg', ['name' => __('messages.order')]));
        }

        return redirect()->route('order.index')->with('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.order')]));
    }
}
