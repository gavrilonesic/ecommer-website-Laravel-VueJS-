<?php

namespace App\Helpers;

use Auth;
use Cart;
use Session;

class CartStorage
{
    /**
     * Returns the list of statuses in key:value pair
     *
     * @return array Array of Statuses
     */
    public static function getCount()
    {
        if (Auth::guard('web')->check()) {
            config(['shopping_cart.storage' => \App\DBStorage::class]);
            $cartSessionId = Auth::guard('web')->user()->id;
        } else if (Session::has(config('constants.CART_SESSION'))) {
            $cartSessionId = Session::get(config('constants.CART_SESSION'));
        }
        if (empty($cartSessionId)) {
            return 0;
        }
        if (!Auth::guard('web')->check()) {
            Session::put('cartSession', Cart::session($cartSessionId)->getContent()->toArray());
        }
        return Cart::session($cartSessionId)->getContent()->count();
    }
}
