<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\FrontController;
use App\Product;
use App\Wishlist;
use Auth;
use Illuminate\Http\Request;

class WishlistController extends FrontController
{
    public function index()
    {
        if (empty(setting('wish_list_in_the_frontend'))) {
            abort(404);
        }
        $wishlists = Product::whereHas('wishlists', function ($query) {
            $query->where('user_id', Auth::guard('web')->user()->id);
        })->with(['brand', 'medias' => function ($query) {
            $query->whereJsonContains('custom_properties->default_image', true);
        }])->select('id', 'name', 'price', 'brand_id', 'slug')->get();

        return view('front.account.myaccount', compact('wishlists'));
    }

    public function addTo(Request $request)
    {
        if (empty(setting('wish_list_in_the_frontend'))) {
            abort(404);
        }
        try {
            if (!isset(Auth::guard('web')->user()->id)) {
                return response()->json([
                    'login' => route('login') . '?slug=' . $request->product,
                ]);
            }
            if (Wishlist::addToWishlist($request->product)) {
                // $product = Product::where('slug', $request->product)->firstOrFail();
                // if (!empty($product)) {
                //     $data = [
                //         'user_id'    => Auth::guard('web')->user()->id,
                //         'product_id' => $product->id,
                //     ];
                //     Wishlist::firstOrCreate($data, $data);
                return response()->json([
                    'status'  => 'success',
                    "type"    => 'success',
                    "message" => __('messages.item_successfully_added_to_wishlist'),
                ]);
                //}
            } else {
                return response()->json([
                    "status"  => 'error',
                    "type"    => 'error',
                    "message" => __('messages.item_not_added_to_wishlist'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status"  => 'error',
                "type"    => 'error',
                "message" => __('messages.item_not_added_to_wishlist'),
            ]);
        }
    }

    public function destroy(Request $request)
    {
        if (empty(setting('wish_list_in_the_frontend'))) {
            abort(404);
        }
        $wishlist = Wishlist::where('product_id', $request->product_id)
            ->where('user_id', Auth::guard('web')->user()->id)->first();
        $wishlist->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }

}
