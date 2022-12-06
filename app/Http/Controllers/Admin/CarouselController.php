<?php

namespace App\Http\Controllers\Admin;

use App\Carousel;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\CarouselRequest;
use Exception;
use Illuminate\Http\Request;
use SEO;
use Session;

class CarouselController extends AdminController
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
    public $activeSidebarSubMenu = 'carousels';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEO::setTitle(__('messages.carousels'));
        $carousels = Carousel::with(['medias', 'backgroundimg'])->orderBy('id', 'DESC')->get();
        return view('admin.carousel.index', compact('carousels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function create(Carousel $carousel)
    {
        SEO::setTitle(__('messages.add_carousel'));
        return view('admin.carousel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarouselRequest $request, Carousel $carousel)
    {
        try {
            $data = $request->all();
            $carousel = Carousel::create($data);
            if (!empty($request->image)) {
                $carousel->addMediaFromRequest('image')->toMediaCollection('carousel', 'carousels');
            }
            if (!empty($request->background_image)) {
                $carousel->addMediaFromRequest('background_image')->toMediaCollection('background_carousel', 'carousels');
            }
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.carousel')]));
            return redirect()->route('carousel.index');

        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_added_error_msg', ['name' => __('messages.carousel')]));
            return redirect()->back()->withInput($request->all());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Carousel  $carousel
     * @param  \App\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function show(Carousel $carousel)
    {
        SEO::setTitle(__('messages.view_carousel'));
        return view('admin.carousel.show', compact('carousel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Carousel  $carousel
     * @param  \App\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function edit(Carousel $carousel)
    {
        SEO::setTitle(__('messages.edit_carousel'));
        $carousels = Carousel::pluck('heading', 'description', 'button_text', 'link');
        return view('admin.carousel.edit', compact('carousel', 'carousels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(CarouselRequest $request, Carousel $carousel)
    {
        try {
            $data = $request->all();
            $carousel->update($data);
            if (!empty($request->image)) {
                try {
                    $mediaItems = $carousel->getMedia('carousel');
                    $carousel->addMediaFromRequest('image')->toMediaCollection('carousel', 'carousels');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {

                    Session::flash('error', __("messages.image_not_update"));
                    return redirect()->route('carousel.index');
                }
            }
            if (!empty($request->background_image)) {
                try {
                    $mediaItems = $carousel->getMedia('background_carousel');
                    $carousel->addMediaFromRequest('background_image')->toMediaCollection('background_carousel', 'carousels');
                    if ($mediaItems->count() > 0) {
                        $mediaItems[0]->delete();
                    }
                } catch (Exception $e) {

                    Session::flash('error', __("messages.image_not_update"));
                    return redirect()->route('carousel.index');
                }
            }
            Session::flash('success', __('messages.record_updated_success_msg', ['name' => __('messages.carousel')]));
            return redirect()->route('carousel.index');
        } catch (Exception $e) {
            Session::flash('error', __('messages.record_not_updated_error_msg', ['name' => __('messages.carousel')]));
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
    public function destroy(Request $request, Carousel $carousel)
    {
        try {
            $carousel->delete();
            Session::flash('success', __('messages.record_deleted_success_msg', ['name' => __('messages.carousel')]));
            return redirect()->route('carousel.index');

        } catch (Exception $e) {

            Session::flash('error', __('messages.record_can_not_be_deleted_error_msg', ['name' => __('messages.carousel')]));
            return redirect()->route('carousel.index');

        }
    }

    //deletes image from edit page if user wants to
    public function deleteimage(Carousel $carousel, Request $request)
    {
        if (empty($request->type)) {
            abort(404);
        }
        try {
            $mediaItems = $carousel->getMedia($request->type);
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
