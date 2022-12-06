<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\BrandRequest;
use Exception;
use Illuminate\Http\Request;
use SEO;
use Session;

class BrandController extends AdminController
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
    public $activeSidebarSubMenu = 'brands';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.brands'));

        $brands = Brand::orderBy('id', 'DESC')->with(['medias'])->get();

        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_brand'));

        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        try {
            $brand = Brand::create($request->all());

            if (!empty($request->image)) {
                $brand->addMediaFromRequest('image')->toMediaCollection('brand', 'brands');
            }

            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.brand')]));

            return redirect()->route('brand.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.brand')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        SEO::setTitle(__('messages.view_brand'));

        return view('admin.brand.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        SEO::setTitle(__('messages.edit_brand'));

        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        try {
            $brand->update($request->all());
            if (!empty($request->image)) {
                try {
                    $mediaItems = $brand->getMedia('brand');
                    $brand->addMediaFromRequest('image')->toMediaCollection('brand', 'brands');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {
                    Session::flash('error', __("messages.image_not_update"));

                    return redirect()->route('brand.index');
                }
            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.brand')]));

            return redirect()->route('brand.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.brand')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.brand')]));

            return redirect()->route('brand.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.brand')]));

            return redirect()->route('brand.index');
        }
    }

    //deletes image from edit page if user wants to
    public function deleteimage(Brand $brand, Request $request)
    {
        if (empty($request->type)) {
            abort(404);
        }
        try {
            $mediaItems = $brand->getMedia($request->type);
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
