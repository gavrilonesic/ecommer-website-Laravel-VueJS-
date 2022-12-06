<?php

namespace App;

use App\Traits\ExtendedSluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Category extends Model implements HasMedia
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use ExtendedSluggable;
    use HasMediaTrait;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'parent_id', 'level', 'short_description', 'description', 'template_layout', 'sort_order', 'page_title', 'meta_tag_keywords', 'meta_tag_description', 'status','email',
    ];

    public static $routeUrl = 'category/';

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

    public function medias()
    {
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\Category");
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function childs()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id');
    }

    public function setShortDescriptionAttribute($value)
    {
        if (empty($value)) {
            $value = substr(strip_tags($this->description), 0, 200);
        }
        $this->attributes['short_description'] = $value;
    }
    /**
     * Get the index name for the model.
     *
     * @return string
     */

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function registerMediaConversions(Media $media = null)
    {
        if (isset($media->collection_name) && $media->collection_name == "logo") {
            $thumbPath = 'CATEGORY_LOGO_THUMB';
        } else {
            $thumbPath = 'CATEGORY_THUMB';
        }
        if ($thumbPath == 'CATEGORY_LOGO_THUMB') {
            $this->addMediaConversion('thumb')
                ->fit(Manipulations::FIT_FILL, config("constants.$thumbPath.WIDTH"), config("constants.$thumbPath.HEIGHT"))
                ->background('white')->nonQueued();

            $this->addMediaConversion('medium')
                ->fit(Manipulations::FIT_FILL, config('constants.MEDIUM_IMAGE.WIDTH'), config('constants.MEDIUM_IMAGE.HEIGHT'))
                ->background('white')->nonQueued();
        } else {
            $this->addMediaConversion('thumb')
                ->crop(Manipulations::CROP_CENTER, config("constants.$thumbPath.WIDTH"), config("constants.$thumbPath.HEIGHT"))
                ->nonQueued();

            $this->addMediaConversion('medium')
                ->crop(Manipulations::CROP_CENTER, config('constants.MEDIUM_IMAGE.WIDTH'), config('constants.MEDIUM_IMAGE.HEIGHT'))
                ->nonQueued();
        }
    }

    public function setPageTitleAttribute($value)
    {
        if (empty($value)) {
            $value = $this->name;
        }
        $this->attributes['page_title'] = $value;
    }

    public function setParentIdAttribute($value)
    {
        if (empty($value)) {
            $value = 0;
        }
        $this->attributes['parent_id'] = $value;
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'category_product');
    }

    public function productsCount()
    {
        return $this->belongsToMany('App\Product', 'category_product')->whereNull('products.deleted_at')->selectRaw('count(products.id) as aggregate')
            ->groupBy('pivot_category_id');
    }

    public function inquiry()
    {
        return $this->hasMany('App\CategoryInquiry','category_id','id');
    }

    public static function categoryList()
    {
        return Category::where('parent_id', '=', 0)->get();
    }

    public static function allCategoryList()
    {
        return Category::orderBy('name', 'asc')->pluck('name', 'id');
    }

    public function attributes()
    {
        return $this->belongsToMany('App\Attribute', 'attribute_category');
    }

    public static function treeList($id = null)
    {
        $level = Category::orderBy('level', 'DESC')->first();
        $tree  = Category::where('parent_id', '=', 0);

        if (!empty($level->level)) {
            for ($i = 1; $i <= $level->level + 1; $i++) {
                $withArray[] = rtrim(str_repeat('childs.', $i), '.');
            }
            $tree = $tree->with($withArray);
        }
        return $tree->get();
    }

    public function scopeActive($query)
    {
        return $query->where('categories.status', config('constants.STATUS.STATUS_ACTIVE'));
    }
}
