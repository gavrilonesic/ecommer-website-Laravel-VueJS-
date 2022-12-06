<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReviewsDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\ReviewRequestAdmin;
use App\Product;
use App\Review;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use SEO;
use Session;

class ReviewController extends AdminController
{
    /**
     * Active sidebar menu
     *
     * @var string
     */
    public $activeSidebarMenu = 'products';

    /**
     * Active sidebar sub menu
     *
     * @var string
     */
    public $activeSidebarSubMenu = 'reviews';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReviewsDataTable $dataTable)
    {
        SEO::setTitle(__('messages.reviews'));
        return $dataTable->render('admin.review.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_review'));
        $products = Product::pluck('name', 'id');
        return view('admin.review.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {

        try {
            $review = Review::create($request->all());
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.review')]));

            return redirect()->route('review.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.review')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        SEO::setTitle(__('messages.view_review'));
        return view('admin.review.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        SEO::setTitle(__('messages.edit_review'));
        $products = Product::pluck('name', 'id');
        return view('admin.review.edit', compact('review', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequestAdmin $request, Review $review)
    {
        try {
            $review->update($request->all());
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.review')]));
            return redirect()->route('review.index');
        } catch (Exception $e) {
            dd($e);
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.review')]));
            return redirect()->back()->withInput($request->all());
        }
    }

    public function changeStatus(Review $review)
    {
        if ($review->status == '1') {
            $review->status       = '2';
            $review->publish_date = null;
        } else if ($review->status == '2') {
            $review->status       = '1';
            $review->publish_date = Carbon::today();
        }
        $review->save();
        Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.review')]));
        return redirect()->route('review.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        try {
            $review->delete();
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.review')]));
            return redirect()->route('review.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.review')]));
            return redirect()->route('review.index');

        }
    }
}
