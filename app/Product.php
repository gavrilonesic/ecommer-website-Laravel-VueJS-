<?php

namespace App;

use App\Traits\ExtendedSluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Product extends Model implements HasMedia
{

    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use HasMediaTrait;
    use ExtendedSluggable;
    use SoftDeletes;
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['big_id', 'is_hazmat', 'is_shipping_by_air', 'name', 'brand_id', 'product_type', 'sku', 'price', 'slug', 'short_description', 'description', 'weight', 'depth', 'width', 'height', 'category_id', 'video_id', 'youtube_url', 'attribute_id', 'attribute_option_id', 'inventory_tracking', 'inventory_tracking_by', 'quantity', 'low_stock', 'mark_as_new', 'mark_as_featured', 'custom_field_id', 'tax_class_id', 'page_title', 'meta_tag_keywords', 'meta_tag_description', 'status', 'include_in_feed'
    ];

    public static $routeUrl = 'product/';

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_product');
    }
    public function videos()
    {
        return $this->belongsToJson('App\Video', 'video_id');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Wishlist', 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function productSkus()
    {
        return $this->hasMany('App\ProductSku');
    }

    public function medias()
    {
        return $this->hasMany('App\Media', 'model_id')->where('model_type', "App\Product")->orderBy('order_column');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review')->where('status', '=', '1');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', config('constants.STATUS.STATUS_ACTIVE'));
    }

    public static function getSlug($productId)
    {
        if (!empty($productId)) {
            return Product::where('id', $productId)->pluck('slug');
        }
        // else {
        //     return Product::pluck('name','id');
        // }
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function relatedProducts()
    {
        return $this->belongsToMany(self::class, 'related_products', 'product_id', 'related_product_id');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function setPageTitleAttribute($value)
    {
        if (empty($value)) {
            $value = $this->name;
        }
        $this->attributes['page_title'] = $value;
    }

    public function setVideoIdAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['video_id'] = json_encode($value, JSON_NUMERIC_CHECK);
        } else {
            $this->attributes['video_id'] = null;
        }
    }
    public function getVideoIdAttribute()
    {
        if (!empty($this->attributes['video_id'])) {
            return json_decode($this->attributes['video_id']);
        } else {
            return [];
        }
    }
    public function setYoutubeUrlAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['youtube_url'] = json_encode($value, JSON_NUMERIC_CHECK);
        } else {
            $this->attributes['youtube_url'] = null;
        }
    }
    public function getYoutubeUrlAttribute()
    {
        if (!empty($this->attributes['youtube_url'])) {
            return json_decode($this->attributes['youtube_url']);
        } else {
            return [];
        }
    }

    public function setShortDescriptionAttribute($value)
    {
        if (empty($value)) {
            $value = substr(strip_tags($this->description), 0, 150);
        }
        $this->attributes['short_description'] = $value;
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

    public static function productList($productId = null)
    {
        if (!empty($productId)) {

            return Product::where('id', "<>", $productId)->pluck('name', 'id');
        } else {

            return Product::pluck('name', 'id');
        }

    }

    public function getCategoryIdAttribute()
    {
        if (!empty($this->attributes['category_id'])) {
            return json_decode($this->attributes['category_id']);
        } else {
            return [];
        }

    }

    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = json_encode($value, JSON_NUMERIC_CHECK);
    }

    public function getAttributeIdAttribute()
    {
        if (!empty($this->attributes['attribute_id'])) {
            return json_decode($this->attributes['attribute_id']);
        } else {
            return [];
        }
    }

    public function setAttributeIdAttribute($value)
    {
        $this->attributes['attribute_id'] = json_encode($value, JSON_NUMERIC_CHECK);
    }

    public function getAttributeOptionIdAttribute()
    {
        if (!empty($this->attributes['attribute_option_id'])) {
            return json_decode($this->attributes['attribute_option_id']);
        } else {
            return [];
        }
    }
    public function setAttributeOptionIdAttribute($value)
    {
        $this->attributes['attribute_option_id'] = json_encode($value, JSON_NUMERIC_CHECK);
    }
    public function setCustomFieldsAttribute($value)
    {
        $this->attributes['custom_fields'] = json_encode($value);
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
