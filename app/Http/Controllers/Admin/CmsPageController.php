<?php

namespace App\Http\Controllers\Admin;

use App\CmsPage;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\CmsPageRequest;
use Exception;
use File;
use Illuminate\Http\Request;
use SEO;
use Session;
use Spatie\MediaLibrary\Models\Media;

class CmsPageController extends AdminController
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
    public $activeSidebarSubMenu = 'cmsPages';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.cms_pages'));

        $cmsPages = CmsPage::orderBy('id', 'DESC')->get();

        return view('admin.cms_page.index', compact('cmsPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_cms_page'));

        return view('admin.cms_page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CmsPageRequest $request)
    {
        try {
            $cmsPage = CmsPage::create($request->all());

            if (!empty($request->image)) {
                $cmsPage->addMediaFromRequest('image')->toMediaCollection('cms_page', 'cms_pages');
            }

            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.cms_page')]));

            return redirect()->route('cms_page.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.cms_page')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CmsPage  $cmsPage
     * @return \Illuminate\Http\Response
     */
    public function show(CmsPage $cmsPage)
    {
        SEO::setTitle(__('messages.view_cms_page'));

        return view('admin.cms_page.show', compact('cmsPage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CmsPage  $cmsPage
     * @return \Illuminate\Http\Response
     */
    public function edit(CmsPage $cmsPage)
    {
        SEO::setTitle(__('messages.edit_cms_page'));

        return view('admin.cms_page.edit', compact('cmsPage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CmsPage  $cmsPage
     * @return \Illuminate\Http\Response
     */
    public function update(CmsPageRequest $request, CmsPage $cmsPage)
    {
        try {
            $cmsPage->update($request->all());
            if (!empty($request->image)) {
                try {
                    $mediaItems = $cmsPage->getMedia('cms_page');
                    $cmsPage->addMediaFromRequest('image')->toMediaCollection('cms_page', 'cms_pages');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {
                    Session::flash('error', __("messages.image_not_update"));

                    return redirect()->route('cms_page.index');
                }
            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.cms_page')]));

            return redirect()->route('cms_page.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.cms_page')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CmsPage  $cmsPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(CmsPage $cmsPage)
    {
        try {
            $cmsPage->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.cms_pages')]));

            return redirect()->route('cms_page.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.cms_pages')]));

            return redirect()->route('cms_page.index');
        }
    }

    //deletes image from edit page if user wants to
    public function deleteimage(CmsPage $cmsPage,Request $request)
    {
        if (empty($request->type)) {
            abort(404);
        }
        try {
            $mediaItems = $cmsPage->getMedia($request->type);
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
