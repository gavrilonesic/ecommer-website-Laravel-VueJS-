<?php

namespace App;

use App\Product;
use Carbon\Carbon;
use App\CartStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'uses_per_customer', 'uses_per_coupon', 'code', 'price_type', 'discount_type', 'percent_price', 'date_start', 'date_end', 'status'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'is_valid'
    ];

    public function getIsValidAttribute()
    {
        if (($this->attributes['status'] ?? null) != config('constants.STATUS.STATUS_ACTIVE')) {
            return false;
        }

        if (! is_null($this->attributes['date_end'] ?? null) && date('Y-m-d H:i:s') > ($this->attributes['date_end'] ?? null)) {
            return false;
        }

        return true;
    }

    /**
     * @param  User    $user
     * @return boolean      
     * @throws \Exception
     */
    public function isValidForUser(User $user)
    {
        $couponCount = $user->coupons()->where('coupon_id', $this->id)->count();

        if ((int) $this->uses_per_customer > 0 && (int) $couponCount >= (int) $this->uses_per_customer) {
            throw new \Exception(__('messages.uses_per_customer_coupon_limit_exceed_error'));
        }

        $couponCount = $this->userCoupons()->count();

        if ((int) $this->uses_per_coupon > 0 && (int) $couponCount > (int) $this->uses_per_coupon) {
            throw new \Exception(__('messages.uses_per_coupon_limit_exceed_error'));
        }

        return true;
    }

    public function userCoupons()
    {
        return $this->belongsToMany('App\User');
    }

    public function user()
    {
        return $this->belongsToMany('App\User');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return float
     */
    public function getDiscountValue(array $products = [])
    {
        if (! isset($this->exists) || $this->exists === false) {
            return 0;
        }

        $preDiscountGrandTotal = CartStorage::grandTotalCalculate();

        $hazmatCost = CartStorage::isHazmat() ? CartStorage::hazmatCost() : 0;

        if ($this->products->isEmpty() && count($products) === 0) {
            $grandTotal = CartStorage::discountedGrandTotalCalculate($this->percent_price, $this->price_type);

            return round($preDiscountGrandTotal['grandTotal'] - $grandTotal + $hazmatCost, 2);
        }

        $products = $this->products->isEmpty() && count($products) > 0
            ? $products
            : $this->products->pluck('id')->toArray();

        $couponProductsDiscount = CartStorage::discountedGrandTotalCalculate($this->percent_price, $this->price_type, 'price', function($cartProduct) use ($products) {

            if (! in_array($cartProduct->id, $products)) {
                return false;
            }

            return true;
        });

        $productsDiscount = CartStorage::discountedGrandTotalCalculate(0, $this->price_type, 'price', function($cartProduct) use ($products) {
            if (! in_array($cartProduct->id, $products)) {
                return true;
            }

            return false;
        });

        return round($preDiscountGrandTotal['grandTotal'] - ($couponProductsDiscount + $productsDiscount) + $hazmatCost, 2);
    }

    /**
     * @param  Product $product
     * @return float
     */
    public function getDiscountValueForProduct(Product $product)
    {
        if (! isset($this->exists) || $this->exists === false) {
            return 0;
        }

        $preDiscountGrandTotal = CartStorage::grandTotalCalculate();

        $products = $this->products->pluck('id')->toArray();

        $couponProductDiscount = CartStorage::discountedGrandTotalCalculate($this->percent_price, $this->price_type, 'price', function($cartProduct) use ($products, $product) {
            if (! in_array($cartProduct->id, $products)) {
                return false;
            }

            if ($cartProduct->id != $product->id) {
                return false;
            }

            return true;
        });

        $productDiscount = CartStorage::discountedGrandTotalCalculate(0, $this->price_type, 'price', function($cartProduct) use ($products, $product) {

            if (! in_array($cartProduct->id, $products)) {
                return true;
            }

            if ($cartProduct->id != $product->id) {
                return true;
            }

            return false;
        });

        if ($couponProductDiscount == 0) {
            return 0;
        }

        return $preDiscountGrandTotal['grandTotal'] - ($couponProductDiscount + $productDiscount);
    }

    /**
     * @return boolean
     */
    public static function displayCouponBox()
    {
        if (setting('apply_coupon') === false) {
            return false;
        }

        $couponCount = Self::where('status', config('constants.STATUS.STATUS_ACTIVE'))->where(function ($query) {
            $query->whereDate('date_start', '<=', Carbon::now())
                ->whereDate('date_end', '>=', Carbon::now())
                ->orWhere(function ($query) {
                    $query->whereNull('date_start');
                });
        })
        ->count();

        return (int) $couponCount > 0;
    }

    /**
     * @param  Coupon     $coupon
     * @param  Collection $appliedCoupons
     * @return bool
     */
    public static function canApplyCoupon(Coupon $coupon, array $appliedCoupons = [])
    {
        $cart = CartStorage::getCart();
        $productsInCart = collect(array_values($cart['cart']))->pluck('attributes')->pluck('product_id')->toArray();
        $coupons = Coupon::whereIn('code', $appliedCoupons)->with('products')->get();

        $orderCoupon = $coupons->reject(function($coupon) {
            return ! $coupon->products->isEmpty();
        })->first();

        if ($coupon->products->isEmpty() && $orderCoupon !== null && $coupon->id !== $orderCoupon->id) {
            return false;
        }

        $productCoupons = $coupons->pluck('products')->flatten()->pluck('id')->toArray();

        if (
            ! in_array($coupon->id, $coupons->pluck('id')->toArray()) &&
            count(array_intersect($productCoupons, $productsInCart)) > 0 && 
            count(array_intersect($coupon->products->pluck('id')->toArray(), $productsInCart)) > 0
        ) {
            return false;
        }

        return true;
    }
}
