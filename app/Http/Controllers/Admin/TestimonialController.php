<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\TestimonialRequest;
use App\Testimonial;
use Exception;
use File;
use Illuminate\Http\Request;
use SEO;
use Session;
use Spatie\MediaLibrary\Models\Media;

class TestimonialController extends AdminController
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
    public $activeSidebarSubMenu = 'testimonials';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.testimonials'));

        $testimonials = Testimonial::orderBy('id', 'DESC')->get();

        return view('admin.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle(__('messages.add_testimonial'));

        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestimonialRequest $request)
    {
        try {
            $testimonial = Testimonial::create($request->all());

            if (!empty($request->image)) {
                $testimonial->addMediaFromRequest('image')->toMediaCollection('testimonial', 'testimonials');
            }

            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.testimonial')]));

            return redirect()->route('testimonial.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.testimonial')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        SEO::setTitle(__('messages.view_testimonial'));

        return view('admin.testimonial.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {
        SEO::setTitle(__('messages.edit_testimonial'));

        return view('admin.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        try {
            if ($request->changestatus == 1) {
                Testimonial::where('id', $testimonial->id)->update(['status' => 0]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.testimonial')]));
                return redirect()->route('testimonial.index');
            } else if (isset($request->changestatus) && $request->changestatus == 0) {
                Testimonial::where('id', $testimonial->id)->update(['status' => 1]);
                Session::flash('success', __('messages.record_status_updated_success_msg', ['name' => __('messages.coupon')]));
                return redirect()->route('testimonial.index');
            }
            $testimonial->update($request->all());
            if (!empty($request->image)) {
                try {
                    $mediaItems = $testimonial->getMedia('testimonial');
                    $testimonial->addMediaFromRequest('image')->toMediaCollection('testimonial', 'testimonials');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {
                    Session::flash('error', __("messages.image_not_update"));

                    return redirect()->route('testimonial.index');
                }
            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.testimonial')]));

            return redirect()->route('testimonial.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.testimonial')]));

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        try {
            $testimonial->delete();

            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.testimonial')]));

            return redirect()->route('testimonial.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.testimonial')]));

            return redirect()->route('testimonial.index');
        }
    }

    //deletes image from edit page if user wants to
    public function deleteimage(Testimonial $testimonial,Request $request)
    {
        if (empty($request->type)) {
            abort(404);
        }
        try {
            $mediaItems = $testimonial->getMedia($request->type);
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
