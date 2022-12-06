<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Brand;
use App\Category;
use App\Http\Controllers\Admin\AdminController;
use Exception;
use Illuminate\Http\Request;
use SEO;
use Session;

class BannerController extends AdminController
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
    public $activeSidebarSubMenu = 'banners';

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function index(Banner $banner)
    {
        SEO::setTitle(__('messages.banners'));
        $banners = Banner::select('id', 'name', 'link', 'show_on_page', 'category_name', 'brand_name', 'visibility', 'date_start', 'date_end')->orderBy('created_at', 'DESC')->get();
        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function create(Banner $banner)
    {
        SEO::setTitle(__('messages.add_banner'));
        $brands     = Brand::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        return view('admin.banner.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Banner $banner)
    {
        // dd($request->all());
        try {
            $data = $request->all();
            if (!empty($data['show_on_page']) && $data['show_on_page'] == 'for_specific_category') {
                $data['brand_id']   = null;
                $data['brand_name'] = null;
            } else if (!empty($data['show_on_page']) && $data['show_on_page'] == 'for_specific_brand') {
                $data['category_id']   = null;
                $data['category_name'] = null;
            } else {
                $data['brand_id']      = null;
                $data['brand_name']    = null;
                $data['category_id']   = null;
                $data['category_name'] = null;
            }
            if (!isset($data['visibility'])) {
                $data['visibility'] = 0;
            }
            $banner = Banner::create($data);
            if (!empty($request->image)) {
                $banner->addMediaFromRequest('image')->toMediaCollection('banner', 'banners');
            }
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.banner')]));
            return redirect()->route('banner.index');

        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.banner')]));
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banner  $banner
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Banner $banner)
    {
        SEO::setTitle(__('messages.view_banner'));
        //dd($banner);
        return view('admin.banner.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banner  $banner
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Banner $banner)
    {
        SEO::setTitle(__('messages.edit_banner'));
        $brands     = Brand::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        //dd($banner);
        return view('admin.banner.edit', compact('categories', 'brands', 'banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        try {
            $data = $request->all();
            if (!empty($data['show_on_page']) && $data['show_on_page'] == 'for_specific_category') {
                $data['brand_id']   = null;
                $data['brand_name'] = null;
            } else if (!empty($data['show_on_page']) && $data['show_on_page'] == 'for_specific_brand') {
                $data['category_id']   = null;
                $data['category_name'] = null;
            } else {
                $data['brand_id']      = null;
                $data['brand_name']    = null;
                $data['category_id']   = null;
                $data['category_name'] = null;
            }
            if (!isset($data['visibility'])) {
                $data['visibility'] = 0;
            }

            if (!isset($data['display_in_all_page'])) {
                $data['display_in_all_page'] = 0;
            }

            $banner->update($data);
            if (!empty($request->image)) {
                try {
                    $mediaItems = $banner->getMedia('banner');
                    $banner->addMediaFromRequest('image')->toMediaCollection('banner', 'banners');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {

                    Session::flash('error', __("messages.image_not_update"));
                    return redirect()->route('banner.index');
                }
            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.banner')]));
            return redirect()->route('banner.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.banner')]));
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Banner $banner)
    {
        try {
            $banner->delete();
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.banner')]));
            return redirect()->route('banner.index');

        } catch (Exception $e) {

            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.banner')]));
            return redirect()->route('banner.index');

        }
    }
}
