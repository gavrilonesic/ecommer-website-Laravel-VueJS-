<?php

namespace App\Http\Controllers\Front;

use Log;
use Auth;
use SEOMeta;
use Session;
use Exception;
use OpenGraph;
use App\Review;
use App\Product;
use App\Category;
use App\Attribute;
use App\ProductSku;
use App\Inspections\Spam;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Http\Controllers\Front\FrontController;

class ProductController extends FrontController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct() {
    //     // $this->middleware('auth');
    // }
    public function index(Request $request)
    {
        $products = Product::
            with(['brand', 'medias' => function ($query) {
            $query->whereJsonContains('custom_properties->default_image', true);
        }])->active()->select('id', 'name', 'brand_id', 'slug', 'price', 'short_description', 'mark_as_new', 'mark_as_featured');

        $category = [];
        if (!empty($request->category)) {
            $products = $products->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.slug', $request->category);
            });
            $category = Category::with('parent')->where('slug', $request->category)->firstOrFail();
        }
        if (!empty($request->search_query)) {
            $products = $products
                ->whereRaw('(LOWER(`meta_tag_description`) LIKE ? or LOWER(`meta_tag_keywords`) LIKE ? or LOWER(`description`) LIKE ? or LOWER(`short_description`) LIKE ? or LOWER(`name`) LIKE ? or LOWER(`sku`) LIKE ? )',
                    [
                        '%' . trim(strtolower($request->search_query)) . '%',
                        '%' . trim(strtolower($request->search_query)) . '%',
                        '%' . trim(strtolower($request->search_query)) . '%',
                        '%' . trim(strtolower($request->search_query)) . '%',
                        '%' . trim(strtolower($request->search_query)) . '%',
                        '%' . trim(strtolower($request->search_query)) . '%'
                    ]
                );
        }
        $products->orderBy('mark_as_featured', 'DESC')
            ->orderBy('mark_as_new', 'DESC')
            ->orderBy('name', 'ASC');
        $products = $products->paginate(12);
        return view('front.product.index', compact('products', 'category'));
    }
    public function detail(Request $request)
    {
        $productQuery = Product::with(['reviews' => function ($query) {
            $query->orderBy('publish_date', 'DESC');
        }, 'videos.medias', 'productSkus' => function ($query) {
            $query->with(['productSkuValues' => function ($query) {
                $query->with('attributeOptions');
            }, 'medias']);
        }, 'medias', 'relatedProducts', 'relatedProducts.medias' => function ($query) {
            $query->whereJsonContains('custom_properties->default_image', true);
        }])->where('slug', $request->product);
        if (!Auth::guard('admin')->check()) {
            $productQuery->active();
        }
        $product = $productQuery->firstOrFail();

        // if (!empty($product->attribute_id) && is_array($product->attribute_id)) {
        $attributes = Attribute::whereIn('id', $product->attribute_id)->get();
        // }

        $productSkus = $product->productSkus->first();

        $quantity = $this->calculateStock($product, $productSkus);

        if (count($product->reviews) > 0) {
            $total = 0;
            $total = $product->reviews->pluck('rating')->sum();
            // foreach ($product->reviews as $key => $value) {
            //     $total += $value->rating;
            // }
            $avg = ($total / $product->reviews->count());
        } else {
            $avg = 0;
        }
        SEOMeta::setTitle($product->page_title ?? $product->name);
        SEOMeta::setDescription($product->meta_tag_description ?? $product->short_description);
        SEOMeta::setKeywords($product->meta_tag_keywords ?? $product->name);
        if (!empty($product->medias) && $product->medias->count() > 0) {
            OpenGraph::addImage($product->medias->first()->getFullUrl());
        }

        $responseData = compact('product', 'attributes', 'avg', 'productSkus', 'quantity');

        if ($request->ajax()) {
            return response()->json($responseData);
        }

        return view('front.product.detail', $responseData);
    }

    public function quickView(Request $request)
    {
        $product = Product::where('slug', $request->slug)
            ->with(['brand', 'medias' => function ($query) {
                $query->whereJsonContains('custom_properties->default_image', true);
            }, 'productSkus' => function ($query) {
                $query->with(['productSkuValues' => function ($query) {
                    $query->with('attributeOptions');
                }, 'medias']);
            }])
            ->get()->first();

        $productSkus = $product->productSkus->first();

        $quantity = $this->calculateStock($product, $productSkus);

        // if (!empty($product->attribute_id) && is_array($product->attribute_id)) {
        $attributes = Attribute::whereIn('id', $product->attribute_id)->get();
        // }

        return view('front.product.quick_view', compact('product', 'attributes', 'productSkus', 'quantity'));
    }

    public function updateProductDetail(Request $request)
    {
        if (!empty($request->attribute_options)) {
            $product = Product::where('slug', $request->slug)
                ->with(['medias' => function ($query) {
                    $query->whereJsonContains('custom_properties->default_image', true);
                }, 'productSkus' => function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        foreach ($request->attribute_options as $key => $value) {
                            $query->whereJsonContains('attribute_option_id', (int) $value);
                        }
                    })
                    // $query->whereJsonContains('attribute_option_id',array_values($request->attribute_options))
                    // $query->whereHas('productSkuValues', function ($query) use ($request) {
                    //     foreach ($request->attribute_options as $key => $value) {
                    //         $query->where([['attribute_id', $key], ['attribute_option_id', $value]]);
                    //     }
                    // })
                        ->with('medias');
                }])->get()->first();

            $productSkus = $product->productSkus->first();

            if (!empty($productSkus) && !empty($productSkus->medias)) {
                $image = $productSkus->medias->getUrl('medium');
            } else if ($product->medias->count() > 0) {
                $image = $product->medias->first()->getUrl('medium');
            }

            if (! $productSkus instanceof ProductSku) {
                $productSkus = new ProductSku;
            }

            return response()->json([
                "image"              => $image ?? asset('images/no-image/default-product-page-list.png'),
                "inventory_tracking" => $product->inventory_tracking,
                "price"              => ! empty($productSkus) && isset($productSkus->price) ? $productSkus->price : $product->price,
                "weight"             => ! empty($productSkus) && isset($productSkus->weight) ? $productSkus->weight : $product->weight,
                "default"            => ! empty($productSkus) && isset($productSkus->medias) ? 0 : 1,
                "is_hazmat"          => ! empty($productSkus->is_hazmat) && isset($productSkus->is_hazmat) ? $productSkus->is_hazmat : $product->is_hazmat,
                "quantity"           => $this->calculateStock($product, $productSkus),
            ]);
        }
    }

    public function calculateStock($product, $productSku)
    {
        if (!empty($product->inventory_tracking) && !empty($product->inventory_tracking_by)) {
            $quantity = $productSku->quantity;
        } else if (!empty($product->inventory_tracking)) {
            $quantity = $product->quantity;
        }

        return isset($quantity) ? $quantity : 0;
    }

    public function addreviews(ReviewRequest $request, Review $review)
    {
        try {
            resolve(Spam::class)->detect($request->input('review_description'));
            resolve(Spam::class)->detect($request->input('review_author'));
            resolve(Spam::class)->detect($request->input('review_title'));
            $data       = $request->all();
            $data['ip'] = \Request::ip();
            $review     = Review::create($data);
            Session::flash('success', __('messages.record_added_success_msg', ['name' => __('messages.review')]));
            return redirect()->back();
        } catch (Exception $e) {
            report($e);
            Log::info(json_encode($request->all()));
            return redirect()->back()->withInput($request->all())->with('error', __('messages.record_add_error_msg', ['name' => __('messages.review')]));
        }
    }

    public function search(Request $request)
    {

        if ($request->ajax()) {
            $prods = Product::with(['categories', 'brand'])->select('sku', 'name', 'slug')
                ->where('status', 1)
                ->whereRaw('(LOWER(`meta_tag_description`) LIKE ? or LOWER(`meta_tag_keywords`) LIKE ? or LOWER(`short_description`) LIKE ? or LOWER(`description`) LIKE ? or LOWER(`name`) LIKE ? or LOWER(`sku`) LIKE ? )',
                [
                    '%' . trim(strtolower($request->q)) . '%',
                    '%' . trim(strtolower($request->q)) . '%',
                    '%' . trim(strtolower($request->q)) . '%',
                    '%' . trim(strtolower($request->q)) . '%',
                    '%' . trim(strtolower($request->q)) . '%',
                    '%' . trim(strtolower($request->q)) . '%'
                ])
                ->active()
                ->limit(5)
                ->orderBy('name', 'asc')
                ->get();
            return $prods;
        } else {
            abort(404);
        }
    }
}
