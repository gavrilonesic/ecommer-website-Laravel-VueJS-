<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\StoreVideoRequest;
use App\Video;
use DB;
use Illuminate\Http\Request;
use SEO;
use Session;

class VideoController extends AdminController
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
    public $activeSidebarSubMenu = 'videos';
    /**
     * Return video blade view and pass videos to it.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $videos = Video::orderBy('created_at', 'DESC')->get();

        return view('admin.video.index')->with('videos', $videos);
    }

    /**
     * Return uploader form view for uploading videos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // echo (int)(str_replace('M', '', ini_get('post_max_size')));die();
        SEO::setTitle(__('messages.add_video'));
        return view('admin.video.create');
    }

    /**
     * Handles form submission after uploader form submits
     * @param StoreVideoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVideoRequest $request)
    {
        DB::beginTransaction();
        try {
            $video = Video::create([
                'title' => $request->title,
            ]);
            $video->addMedia($request->video)->toMediaCollection('video', 'videos');
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.video')]));
            DB::commit();
            return redirect()->route('video.index');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.video')]));

            return redirect()->route('video.index');
        }
    }

    public function edit(video $video)
    {
        SEO::setTitle(__('messages.edit_video'));
        return view('admin.video.edit', compact('video'));
    }

    public function update(video $video, StoreVideoRequest $request)
    {
        DB::beginTransaction();
        try {
            $video->title = $request->title;
            $video->save();
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.video')]));
            DB::commit();
            return redirect()->route('video.index');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.video')]));

            return redirect()->route('video.index');
        }
    }

    public function destroy(Video $video)
    {
        try {
            $video->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.video')]));

            return redirect()->route('video.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.video')]));

            return redirect()->route('video.index');
        }
    }
}
