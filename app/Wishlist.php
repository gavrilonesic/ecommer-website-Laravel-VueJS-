<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_id',
    ];

    public function product()
    {
        $this->belongsTo('App\Product');
    }

    public static function addToWishlist($slug)
    {
        try {
            $product = Product::where('slug', $slug)->firstOrFail();
            if (!empty($product)) {
                $data = [
                    'user_id'    => Auth::guard('web')->user()->id,
                    'product_id' => $product->id,
                ];
                Wishlist::firstOrCreate($data, $data);
                return true;
            }
        } catch (\Exception $e) {

            return false;
        }
    }
}
