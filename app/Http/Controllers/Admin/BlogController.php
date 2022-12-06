<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\BlogCategory;
use App\Http\Controllers\Admin\AdminController;
use Exception;
use Illuminate\Http\Request;
use SEO;
use Session;

class BlogController extends AdminController
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
    public $activeSidebarSubMenu = 'blogs';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Blog $blog)
    {
        SEO::setTitle(__('messages.blogs'));
        $blogs = Blog::select('id', 'name', 'title', 'description', 'status')->orderBy('created_at', 'DESC')->get();
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Blog $blog)
    {
        SEO::setTitle(__('messages.add_blog'));
        $blogcategory = Blogcategory::pluck('name', 'id');
        return view('admin.blog.create', compact('blog', 'blogcategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Blog $blog)
    {
        try {
            $data = $request->all();
            $blog = Blog::create($data);
            if (!empty($request->image)) {
                $blog->addMediaFromRequest('image')->toMediaCollection('blogs', 'blogs');
            }
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.blog')]));
            return redirect()->route('blog.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.blog')]));
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Blog $blog)
    {
        SEO::setTitle(__('messages.view_blog'));
        return view('admin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        SEO::setTitle(__('messages.edit_blog'));
        $blogcategory = Blogcategory::pluck('name', 'id');
        return view('admin.blog.edit', compact('blog', 'blogcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        try {
            if ($request->changestatus == 1) {
                Blog::where('id', $blog->id)->update(['status' => 0]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.blog')]));
                return redirect()->route('blog.index');
            } else if (isset($request->changestatus) && $request->changestatus == 0) {
                Blog::where('id', $blog->id)->update(['status' => 1]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.blog')]));
                return redirect()->route('blog.index');
            }
            $blog->update($request->all());
            if (!empty($request->image)) {
                try {
                    $mediaItems = $blog->getMedia('blogs');
                    $blog->addMediaFromRequest('image')->toMediaCollection('blogs', 'blogs');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {
                    Session::flash('error', __("messages.image_not_update"));
                    return redirect()->route('blog.index');
                }
            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.blog')]));
            return redirect()->route('blog.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.blog')]));
            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        try {
            $blog->delete();
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.blog')]));
            return redirect()->route('blog.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.blog')]));
            return redirect()->route('blog.index');

        }
    }
}
