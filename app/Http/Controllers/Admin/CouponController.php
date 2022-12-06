<?php

namespace App\Http\Controllers\Admin;

use SEO;
use Session;
use Exception;
use App\Coupon;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class CouponController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'marketing';

    /**
     * Active sidebar sub menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'coupons';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.coupons'));
        $coupons = Coupon::select('id', 'name', 'code', 'price_type', 'percent_price', 'date_start', 'date_end', 'status')->with('userCoupons')->get(); //->orderBy('id','DESC')
        //dd(count($coupons[0]->userCoupons));
        return view('admin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_coupon'));

        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'code' => 'required|min:6',
                'date_end' => 'required',
            ]);

            $data = $request->all();

            if (empty($data['price']) || $data['price'] == null) {
                $data['percent_price'] = $data['percentage_value'];
            } else {
                $data['percent_price'] = $data['price'];
            }

            $coupon = Coupon::create($data);

            $productsList = $request->input('coupon_type') == 'product_coupon' && $request->has('products_list') 
                ? array_map('trim', explode(',', $request->input('products_list'))) 
                : [];

            foreach ($productsList as $sku) {
                try {
                    $coupon->products()->attach(
                        Product::whereSku($sku)->firstOrFail()
                    );
                } catch (\Exception $e) {
                }
            }

            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.coupon')]));

            return redirect()->route('coupon.index');

        } catch (Exception $e) {
            Session::flash('danger', __('messages.record_not_added_error_msg', ['name' => __('messages.coupon')]));
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        SEO::setTitle(__('messages.view_coupon'));
        return view('admin.coupon.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        SEO::setTitle(__('messages.edit_coupon'));

        $coupon->loadMissing('products');

        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        try {
            if ($request->changestatus == 1) {
                Coupon::where('id', $coupon->id)->update(['status' => 0]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.coupon')]));
                return redirect()->route('coupon.index');
            } else if (isset($request->changestatus) && $request->changestatus == 0) {
                Coupon::where('id', $coupon->id)->update(['status' => 1]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.coupon')]));
                return redirect()->route('coupon.index');
            }

            $coupon->update($request->all());

            $productsList = $request->input('coupon_type') == 'product_coupon' && $request->has('products_list') 
                ? array_map('trim', explode(',', $request->input('products_list'))) 
                : [];

            $coupon->products()->detach();

            foreach ($productsList as $sku) {
                try {
                    $coupon->products()->attach(
                        Product::whereSku($sku)->firstOrFail()
                    );
                } catch (\Exception $e) {
                }
            }

            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.coupon')]));
            return redirect()->route('coupon.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.coupon')]));
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        try {
            $coupon->delete();
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.coupon')]));
            return redirect()->route('coupon.index');

        } catch (Exception $e) {

            Session::flash('success', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.coupon')]));
            return redirect()->route('coupon.index');

        }
    }
}
