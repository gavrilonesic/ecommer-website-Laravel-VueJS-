<?php

namespace App\Http\Controllers\Front;

use App\CartStorage;
use App\Coupon;
use App\Http\Controllers\Front\FrontController;
use App\Product;
use App\ProductSku;
use Auth;
use Cart;
use Illuminate\Http\Request;

class CartController extends FrontController
{
    /**
     * @return View
     */
    public function index()
    {
        $response = CartStorage::getCart();
        $isHazmat = CartStorage::isHazmat();
        $displayCoupon = Coupon::displayCouponBox();

        extract($response);

        $responseData = compact('cart', 'products', 'displayCoupon', 'isHazmat');

        if (request()->ajax()) {
            return response()->json($responseData);
        }

        return view('front.order.cart', $responseData);
    }

    /**
     * @param Request $request
     */
    public function add(Request $request)
    {
        $product = Product::where('slug', $request->slug)->with(['productSkus' => function ($query) {
            $query->with(['productSkuValues' => function ($query) {
                $query->with('attributeOptions');
            }, 'medias']);
        }])->firstOrFail();

        if ($product->productSkus->count() > 0) {
            return response()->json([
                'attribute' => true,
            ]);
        }

        return $this->addToCart($request);
    }

    /**
     * @param Request $request
     */
    public function addToCart(Request $request)
    {
        try {
            $product = Product::where('slug', $request->slug);
            if (!empty($request->attribute_options)) {
                $product = $product->with(['productSkus' => function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        foreach ($request->attribute_options as $key => $value) {
                            $query->whereJsonContains('attribute_option_id', (int) $value);
                        }
                    });
                }]);
            }

            $product = $product->get()->first();

            $price = round($product->price * 1, 2);

            if (!empty($product->productSkus[0])) {
                $price = round($product->productSkus[0]->price * $request->quantity, 2);
            }

            $productAdded = isset($product->productSkus[0]) & ! empty($product->productSkus[0]) ? $product->productSkus[0] : $product;

            $cart = [
                'id'                => !empty($product->productSkus[0]) ? $product->productSkus[0]->id : 'product-' . $product->id,
                'name'              => $product->name,
                'price'             => $price,
                'quantity'          => $request->quantity ?? 1,
                'attributes'        => [
                    'product_id' => $product->id,
                    'original_price' => $price,
                    'weight'     => $productAdded->weight ?? 0,
                    'length'     => $productAdded->depth ?? 0,
                    'width'      => $productAdded->width ?? 0,
                    'height'     => $productAdded->height ?? 0,
                    'is_hazmat'  => $productAdded->is_hazmat,
                    'hazmat_type'=> $productAdded->hazmat_type ?? ProductSku::HAZMAT_TYPE_NONE,
                    'is_shipping_by_air'  => $productAdded->is_shipping_by_air,
                    'categories' => $product->categories->isEmpty() ? [] : $product->categories->pluck('name')->toArray(),
                    'attribute'  => $request->attribute_options ?? [],
                ],
            ];

            if (Auth::guard('web')->check()) {
                config(['shopping_cart.storage' => \App\DBStorage::class]);
            }

            $cartSessionId = CartStorage::getSession();

            if (Cart::session($cartSessionId)->has($cart['id'])) {
                Cart::session($cartSessionId)
                    ->update($cart['id'], [
                        'quantity' => array(
                            'relative' => false,
                            'value'    => $request->quantity,
                        ),
                        'price' => $cart['price'],
                        'attributes' => [
                            'product_id' => $product->id,
                            'weight'     => $productAdded->weight ?? 0,
                            'length'     => $productAdded->depth ?? 0,
                            'width'      => $productAdded->width ?? 0,
                            'height'     => $productAdded->height ?? 0,
                            'is_hazmat'  => $productAdded->is_hazmat,
                            'hazmat_type'=> $productAdded->hazmat_type ?? ProductSku::HAZMAT_TYPE_NONE,
                            'is_shipping_by_air'  => $productAdded->is_shipping_by_air,
                            'categories' => $product->categories->isEmpty() ? [] : $product->categories->pluck('name')->toArray(),
                            'attribute'  => $request->attribute_options ?? [],
                        ],
                    ]);
            } else {
                Cart::session($cartSessionId)->session($cartSessionId)->add($cart);
            }
            
            return response()->json([
                "status"  => 'success',
                "type"    => 'success',
                "message" => __('messages.item_successfully_added_to_cart') . " &nbsp;&nbsp;&nbsp; <a href='/cart' class='btn btn-success'>Check Out Now</a>",
                "count"   => \App\Helpers\CartStorage::getCount(),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status"  => 'error',
                'e' => $e->getMessage(),
                "type"    => 'error',
                "message" => __('messages.item_not_added_to_cart'),
            ]);
        }
    }

    /**
     * @param  Request $request
     * @return JsonResponse
     */
    public function updateToCart(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $product = null;

        if (!is_numeric($request->id)) {
            $id      = explode('-', $request->id);
            $product = Product::find($id[1]);
        } else {
            $product = ProductSku::find($request->id);
        }

        $price = round($request->quantity * $product->price, 2);

        $cartSessionId = CartStorage::getSession();

        if (!empty($request->quantity)) {
            Cart::session($cartSessionId)
                ->update($request->id, [
                    'quantity' => array(
                        'relative' => false,
                        'value'    => $request->quantity,
                    ),
                    'price'    => $price,
                ]);
        } else {
            Cart::session($cartSessionId)->remove($request->id);
        }

        return response()->json([
            "status"     => "success",
            "price"      => $price,
            "quantity"   => array_sum(array_column(Cart::session($cartSessionId)->getContent()->toArray(), 'quantity')),
            "grandTotal" => round(array_sum(array_column(Cart::session($cartSessionId)->getContent()->toArray(), 'price')), 2),
        ]);
    }
}
