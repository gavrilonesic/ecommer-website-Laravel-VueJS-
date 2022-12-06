<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class ProductSku extends Model implements HasMedia
{

    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    use HasMediaTrait;

    const HAZMAT_TYPE_NONE = 1;
    const HAZMAT_TYPE_ALL = 2;
    const HAZMAT_TYPE_SINGLE = 3;

    const HAZMAT_TYPES = [
        self::HAZMAT_TYPE_NONE => 'None',
        self::HAZMAT_TYPE_ALL => 'Hazmat (All Sizes)',
        self::HAZMAT_TYPE_SINGLE => 'Hazmat (Single)'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'sku', 'attribute_option_id', 'weight', 'depth', 'width', 'height', 'price', 'quantity', 'low_stock', 'media_id', 'include_in_feed', 'is_hazmat', 'hazmat_type', 'is_shipping_by_air'];

    public function productSkuValues()
    {
        return $this->hasMany('App\ProductSkuValue');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_FILL, config('constants.THUMB_IMAGE.WIDTH'), config('constants.THUMB_IMAGE.HEIGHT'))
            ->background('white')->nonQueued();

        $this->addMediaConversion('medium')
            ->fit(Manipulations::FIT_FILL, config('constants.MEDIUM_IMAGE.WIDTH'), config('constants.MEDIUM_IMAGE.HEIGHT'))
            ->background('white')->nonQueued();
    }

    public function medias()
    {
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\ProductSku");
    }

    /**
     * Get hazmat flag
     * 
     * @param  mixed $value 
     * @return bool        
     */
    public function getIsHazmatAttribute($value): bool
    {
        return (int) $value === 1;
    }

    /**
     * Get ship by air
     * 
     * @param  mixed $value 
     * @return bool        
     */
    public function getIsShippingByAirAttribute($value): bool
    {
        return (int) $value === 1;
    }
}
