<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Admin\AdminController;
use App\Order;
use App\OrderItem;
use App\Product;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use SEO;

class HomeController extends AdminController
{

    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'dashboards';

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.dashboard'));
        $data['no_of_customers'] = User::where('is_guest',0)->count();
        $data['order_count']     = Order::active()->count();
        $data['products_count']  = Product::count();
        $data['category_count']  = Category::count();
        // $data['stock_threshold']     = Product::select('id', 'name', 'quantity')->where('low_stock', '<=', 'quantity')->where('inventory_tracking', 1)->limit(5)->get();
        // $data['recent_orders']     = OrderItem::with('order', 'product')->select('id', 'order_id', 'product_id', 'order_status_id', 'created_at')->orderBy('created_at', 'DESC')->limit(10)->get();
        // $data['pending_orders']    = OrderItem::with(['order', 'product'])->select('id', 'order_id', 'product_id', 'order_status_id', 'created_at')->where('order_status_id', '=', 1)->orderBy('created_at', 'DESC')->limit(10)->get();
        // $data['delievered_orders'] = OrderItem::with(['order', 'product'])->select('id', 'order_id', 'product_id', 'order_status_id', 'created_at')->where('order_status_id', '=', 1)->orderBy('created_at', 'DESC')->limit(10)->get();

        $data['total_sale']          = $data['average_sale']          = (Order::active()->sum('order_total') - Order::active()->sum('refund_total'));
        $data['total_order']         = Order::active()->count();
        $data['top_selling_product'] = OrderItem::select(DB::raw('SUM(order_items.quantity) as total'), 'order_items.product_id', 'order_items.order_id')
            ->with(['product' => function ($query) {
                $query->select('id', 'name');
            }, 'product.medias'])
            ->where('order_status_id', config('constants.ORDER_STATUS.COMPLETED'))
            ->orderBy("total", "DESC")
            ->groupBy("order_items.product_id")
            ->limit(5)
            ->get();

        $data['top_customer'] = OrderItem::select(DB::raw('SUM(order_items.quantity) as total'), 'order_items.user_id', 'order_items.order_id')
            ->with(['user' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->where('order_status_id', config('constants.ORDER_STATUS.COMPLETED'))
            ->where('is_guest', '0')
            ->orderBy("total", "DESC")
            ->groupBy("order_items.user_id")
            ->limit(5)
            ->get();

        $data['top_category'] = Category::select(DB::raw('SUM(order_items.quantity) as total'), 'categories.id', 'categories.name')
            ->with('medias')
            ->leftJoin('category_product', 'categories.id', '=', 'category_product.category_id')
            ->leftJoin('order_items', 'category_product.product_id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.order_status_id', config('constants.ORDER_STATUS.COMPLETED'))
            ->where('orders.payment_status', 1)
            ->orderBy("total", "DESC")
            ->groupBy("categories.id")
            ->limit(5)
            ->get();

        $order = Order::active()->select('created_at')->orderBy('id', 'ASC')->first();
        if (!empty($order->created_at)) {
            $date  = Carbon::parse($order->created_at)->startOfMonth();
            $now   = Carbon::now();
            $month = $date->diffInMonths($now->endOfMonth());
            $year  = $date->diffInYears($now);
            if (!empty($month)) {
                $data['average_sale']      = round($data['average_sale'] / ($month + 1), 2);
                $data['monthly_avg_order'] = round($data['total_order'] / ($month + 1), 2);
            }

            if (!empty($year)) {
                $data['yearly_avg_order'] = round($data['total_order'] / ($year + 1));
            }
        }

        return view('admin.home.index', compact('data'));
    }

    public function getGraphData(Request $request)
    {
        $data = Order::sales($request->from, $request->to);
        return $data;
    }

}
