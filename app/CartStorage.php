<?php

namespace App;

use Auth;
use Cart;
use Session;
use App\Coupon;
use App\Product;
use App\AttributeOption;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class CartStorage extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The cart storages that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'cart_data',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function setCartDataAttribute($value)
    {
        $this->attributes['cart_data'] = serialize($value);
    }

    public function getCartDataAttribute($value)
    {
        return unserialize($value);
    }

    public static function getSession()
    {
        if (Auth::guard('web')->check()) {
            $cartSessionId = Auth::guard('web')->user()->id;
        } else {
            if (Session::has(config('constants.CART_SESSION'))) {
                $cartSessionId = Session::get(config('constants.CART_SESSION'));
            } else {
                $cartSessionId = uniqid();
                Session::put(config('constants.CART_SESSION'), $cartSessionId);
            }
        }

        return $cartSessionId;
    }

    public static function getCart()
    {
        $cart          = [];
        $cartSessionId = self::getSession();
        $cart          = Cart::session($cartSessionId)->getContent()->toArray();

        $productId = array_map(function ($value) {
            return $value['attributes']['product_id'];
        }, $cart);

        if (count($productId) === 0) {
            return [
                'cart'     => $cart,
                'products' => [],
            ];
        }

        $products = Product::whereIn('id', array_values(Arr::wrap($productId)))
            ->with(['brand', 'medias' => function ($query) {
                $query->whereJsonContains('custom_properties->default_image', true);
            }, 'productSkus' => function ($query) {
                $query->with(['productSkuValues' => function ($query) {
                    $query->with(['attribute', 'attributeOptions']);
                }, 'medias']);
            }])
            ->select('id', 'name', 'price', 'brand_id', 'slug', 'quantity', 'inventory_tracking', 'inventory_tracking_by', 'weight', 'is_hazmat')
            ->get()
            ->keyBy('id');

        if ($products->count() === 0) {
            return [
                'cart'     => $cart,
                'products' => $products ?? [],
            ];            
        }

        foreach ($cart as &$value) {

            //Select here product sku key from products object
            if (! (!is_string($value['id']) && $products[$value['attributes']['product_id']]->productSkus->count() > 0)) {
                continue;
            }

            $product = $products[$value['attributes']['product_id']];

            foreach ($product->productSkus as $key => $productSkus) {
                if ($productSkus->id != $value['id']) {
                    continue;
                }

                $value['productSku'] = $key;
                break;
            }
        }

        return [
            'cart'     => $cart,
            'products' => $products ?? [],
        ];
    }

    public static function grandTotalCalculate($field = 'price')
    {
        $cartData = CartStorage::getCart();
        extract($cartData);
        $grandTotal = 0;
        if ($products->count() > 0) {
            foreach ($cart as $val) {
                $price = 0;
                if (!is_string($val['id']) && $products[$val['attributes']['product_id']]->productSkus->count() > 0) {
                    $product    = $products[$val['attributes']['product_id']];
                    $productSku = $product->productSkus->filter(function ($item) use ($val) {
                        return $item->id == $val['id'];
                    })->first();
                    $priceOrWeight = $productSku->$field * $val['quantity'];
                } else {
                    $product       = $products[$val['attributes']['product_id']];
                    $priceOrWeight = $product->$field * $val['quantity'];
                }
                $grandTotal = $grandTotal + $priceOrWeight;
            }
        }

        if ($field === 'price' && self::isHazmat()) {
            $grandTotal += self::hazmatCost();
        }

        return [
            'grandTotal' => floatval($grandTotal),
        ];
    }
    
    public static function discountedGrandTotalCalculate($discountAmount, $discountType, $field = 'price', $callback = null)
    {
        $cartData = CartStorage::getCart();
        extract($cartData);

        $grandTotal = 0;

        if ($products->count() === 0) {
            return 0;
        }

        foreach ($cart as $val) {
            $price = 0;

            $product = $products[$val['attributes']['product_id']];

            /**
             * Use a callback to stop the whole code bellow.....
             */
            if ($callback instanceof \Closure && $callback($product) === false) {
                continue;
            }

            if (!is_string($val['id']) && $products[$val['attributes']['product_id']]->productSkus->count() > 0) {
                $productSku = $product->productSkus->filter(function ($item) use ($val) {
                    return $item->id == $val['id'];
                })->first();
                $priceOrWeight = $productSku->$field * $val['quantity'];
            } else {
                $priceOrWeight = $product->$field * $val['quantity'];
            }

            $grandTotal = $grandTotal + $priceOrWeight;
        }

        if ($discountType == "flat_price") {
            if ($grandTotal > $discountAmount) {
                $grandTotal = round($grandTotal - $discountAmount, 2);
            } else {
                $grandTotal = 0;
                $discount   = $grandTotal;
            }

        } else if ($discountType == "percentage") {
            $discount   = round($grandTotal * $discountAmount / 100, 2);
            $grandTotal = round($grandTotal - $discount, 2);
        }

        if ($field === 'price' && self::isHazmat()) {
            $grandTotal += self::hazmatCost();
        }

        return floatval($grandTotal);
    }

    /**
     * Get total cart weight in lbs
     * 
     * @return float
     */
    public static function weight(): float
    {
        try {
            $total = static::grandTotalCalculate('weight'); 
            return is_array($total) && isset($total['grandTotal']) ? floatval($total['grandTotal']) : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get total cart weight in lbs
     * 
     * @return float
     */
    public static function canShipByAir(): bool
    {
        $cartData = self::getCart();

        if (! isset($cartData['cart'])) {
            return false;
        }

        if (count($cartData['cart']) === 0) {
            return false;
        }

        return collect($cartData['cart'])
            ->values()
            ->reject(function($cartItem) {
                $cartItem = (Object) $cartItem;

                if (isset($cartItem->attributes['is_shipping_by_air'])) {
                    return (int) $cartItem->attributes['is_shipping_by_air'] !== 0;
                }

                $product = Product::find($cartItem->attributes['product_id']);
                return (int) $product->is_shipping_by_air !== 0;
            })
            ->isEmpty();
    }

    /**
     * Get total hazmat products
     * 
     * @return int
     */
    public static function hazmatCount(): int
    {
        $cartData = self::getCart();

        if (! isset($cartData['cart'])) {
            return 0;
        }

        if (count($cartData['cart']) === 0) {
            return 0;
        }

        return (int) collect($cartData['cart'])
            ->values()
            ->reject(function($cartItem) {
                $cartItem = (Object) $cartItem;

                if (isset($cartItem->attributes['is_hazmat'])) {
                    return ! $cartItem->attributes['is_hazmat'];
                }

                $product = Product::find($cartItem->attributes['product_id']);
                return ! $product->is_hazmat;
            })
            ->sum('quantity');
    }

    /**
     * Check wether cart is hazmat single
     * 
     * @return bool
     */
    public static function isHazmatSingle(): bool
    {
        $cartData = self::getCart();

        $values = collect($cartData['cart'])->values();

        $type = $values->first()['attributes']['hazmat_type'] ?? ProductSku::HAZMAT_TYPE_NONE;

        return $values->sum('quantity') == 1 && $type == ProductSku::HAZMAT_TYPE_SINGLE;
    }

    /**
     * Get total cart weight in lbs
     * 
     * @return float
     */
    public static function isHazmat(): bool
    {
        try {
            return self::hazmatCount() > 0 && !self::isHazmatSingle();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return float
     */
    public static function hazmatCost(): float
    {
        if (! self::isHazmat()) {
            return 0;
        }

        if (Session::get('shipping_option_chosen','') === 'own') {
            return 0;
        }

        if (Session::get('shipping_option_chosen','') == 'pickup-from-store') {
            // update this logic, pickup from store and valid address for pickup
        }

        try {

            $cartData = self::getCart();

            return collect($cartData['cart'])
                ->values()
                ->reject(function($cartItem) {

                    $cartItem = (Object) $cartItem;

                    if (isset($cartItem->attributes['is_hazmat'])) {
                        return ! $cartItem->attributes['is_hazmat'];
                    }

                    $product = Product::find($cartItem->attributes['product_id']);
                    return ! $product->is_hazmat;
                })
                ->map(function($cartItem) {

                    $cartItem = (Object) $cartItem;

                    $isLtlMode = ((int) $cartItem->attributes['weight'] * (int) $cartItem->quantity) > 130;
                    
                    $hazmatFee = $isLtlMode ? config('constants.ltl_hazmat_shipping_cost') : config('constants.hazmat_shipping_cost');

                    // if ((! is_array($cartItem->attributes['attribute'])) || (count($cartItem->attributes['attribute']) === 0)) {
                    //     return $hazmatFee * (int) $cartItem->quantity;
                    // }

                    // try {
                        
                    //     $option = AttributeOption::findOrFail(
                    //         array_values($cartItem->attributes['attribute'])
                    //     )->first();

                    //     if ($isLtlMode) {
                    //         $multiplier = (int) $option->ltl_multiplier === 1
                    //             ? (int) $cartItem->quantity
                    //             : ceil((int) $cartItem->quantity / $option->ltl_multiplier) % $option->ltl_multiplier;                            
                           
                    //         return ((int) $multiplier <= 0 ? 1 : $multiplier) * $option->ltl_fee;
                    //     }
                    
                    //     $multiplier = (int) $option->hazmat_multiplier === 1
                    //         ? (int) $cartItem->quantity
                    //         : ceil((int) $cartItem->quantity / $option->hazmat_multiplier) % $option->hazmat_multiplier;

                    //     return ((int) $multiplier <= 0 ? 1 : $multiplier) * $option->hazmat_fee;

                    // } catch (\Exception $e) {
                    // }
         
                    return $hazmatFee * (int) $cartItem->quantity;
                })
                ->sum();

        } catch (\Exception $e) {

            $hazmatFee = self::weight() > 130 
                ? config('constants.ltl_hazmat_shipping_cost') 
                : config('constants.hazmat_shipping_cost');

            return $hazmatFee * self::hazmatCount();        
        }
    }
}
