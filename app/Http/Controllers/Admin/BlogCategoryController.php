<?php

namespace App\Http\Controllers\Admin;

use App\BlogCategory;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\BlogCategoryRequest;
use Exception;
use Illuminate\Http\Request;
use SEO;
use Session;

class BlogCategoryController extends AdminController
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
    public $activeSidebarSubMenu = 'blogcategory';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogCategory $blogcategory)
    {
        SEO::setTitle(__('messages.blogcategory'));
        $blogcategory = BlogCategory::select('id', 'name', 'status')->orderBy('created_at', 'DESC')->get();
        return view('admin.blogcategory.index', compact('blogcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BlogCategory $blogcategory)
    {
        SEO::setTitle(__('messages.add_blog_category'));
        return view('admin.blogcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryRequest $request, BlogCategory $blogcategory)
    {
        try {
            $data         = $request->all();
            $blogcategory = BlogCategory::create($data);
            if (!empty($request->image)) {
                $blogcategory->addMediaFromRequest('image')->toMediaCollection('blogcategory', 'blogcategories');
            }
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.blogcategory')]));
            return redirect()->route('blogcategory.index');

        } catch (Exception $e) {

            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.blogcategory')]));
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BlogCategory $blogcategory)
    {
        SEO::setTitle(__('messages.view_blogcategory'));
        return view('admin.blogcategory.show', compact('blogcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogCategory $blogcategory)
    {
        SEO::setTitle(__('messages.edit_blog_category'));
        return view('admin.blogcategory.edit', compact('blogcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryRequest $request, BlogCategory $blogcategory)
    {
        try {
            if ($request->changestatus == 1) {
                BlogCategory::where('id', $blogcategory->id)->update(['status' => 0]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.blogcategory')]));
                return redirect()->route('blogcategory.index');
            } else if (isset($request->changestatus) && $request->changestatus == 0) {
                BlogCategory::where('id', $blogcategory->id)->update(['status' => 1]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.blogcategory')]));
                return redirect()->route('blogcategory.index');
            }
            $blogcategory->update($request->all());
            if (!empty($request->image)) {
                try {
                    $mediaItems = $blogcategory->getMedia('blogcategory');
                    $blogcategory->addMediaFromRequest('image')->toMediaCollection('blogcategory', 'blogcategories');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {

                    Session::flash('error', __("messages.image_not_update"));
                    return redirect()->route('blogcategory.index');
                }
            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.blogcategory')]));
            return redirect()->route('blogcategory.index');
        } catch (Exception $e) {
            // dd($e);
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.blogcategory')]));
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogCategory $blogcategory)
    {
        try {
            $blogcategory->delete();
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.blogcategory')]));
            return redirect()->route('blogcategory.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.blogcategory')]));
            return redirect()->route('blogcategory.index');

        }
    }

    //deletes image from edit page if user wants to
    public function deleteimage(BlogCategory $blogcategory, Request $request)
    {
        if (empty($request->type)) {
            abort(404);
        }
        try {
            $mediaItems = $blogcategory->getMedia($request->type);
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
