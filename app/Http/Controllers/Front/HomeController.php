<?php

namespace App\Http\Controllers\Front;

use App\Banner;
use App\Carousel;
use App\Http\Controllers\Front\FrontController;
use App\OrderItem;
use App\Product;
use App\Testimonial;
use App\Client;
use DB;
use Illuminate\Http\Request;

class HomeController extends FrontController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     parent::__construct();
    //     // $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $carousels        = Carousel::with('medias', 'backgroundimg')->get();
        $testimonials     = Testimonial::orderBy('id', 'DESC')->where('status', '1')->get();
        $clients          = Client::active()->get();
        $smallWidthBanner = Banner::getBannerOnFront(config('constants.BANNER_TYPE.SMALL_WIDTH'), config('constants.BANNER_POSITION.TOP'), 'home_page');
        if ($smallWidthBanner->count() > 3) {
            $smallWidthBanner = $smallWidthBanner->random(3);
        }
        $fullWidthBanner = Banner::getBannerOnFront(config('constants.BANNER_TYPE.FULL_WIDTH'), config('constants.BANNER_POSITION.TOP'), 'home_page');
        if ($fullWidthBanner->count() > 0) {
            $fullWidthBanner = $fullWidthBanner->random(1)->first();
        }

        if (!empty(setting('top_selling_products_on_home_page'))) {
            $popularProducts = OrderItem::with(['product', 'product.brand', 'product.medias' => function ($query) {
                $query->whereJsonContains('custom_properties->default_image', true);
            }])
                ->select('product_id', DB::RAW("count('id') as product_count"))
                ->groupBy('product_id')
                ->orderBy('product_count', 'desc')
                ->limit(10)
                ->get();
        } else {
            $popularProducts = collect([]);
        }
        if (!empty(setting('new_products_on_home_page'))) {
            $newProducts = Product::with(['brand', 'medias' => function ($query) {
                $query->whereJsonContains('custom_properties->default_image', true);
            }])->where('status', '1')->where('mark_as_new', '1')->orderBy('updated_at', 'desc')->take(10)->get();
        } else {
            $newProducts = collect([]);
        }
        if (!empty(setting('featured_products_on_home_page'))) {
            $featuredProducts = Product::with(['brand', 'medias' => function ($query) {
                $query->whereJsonContains('custom_properties->default_image', true);
            }])->where('status', '1')->where('mark_as_featured', '1')->orderBy('updated_at', 'desc')->take(10)->get();
        } else {
            $featuredProducts = collect([]);
        }
        return view('front.home.index', compact('carousels', 'popularProducts', 'testimonials', 'clients', 'smallWidthBanner', 'fullWidthBanner', 'newProducts', 'featuredProducts'));
    }

    public function getpage($slug)
    {
        return view('front.pages.default');
    }
}
