<?php

namespace App;

use App\Traits\ExtendedSluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Brand extends Model implements HasMedia
{
    //
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use HasMediaTrait;
    use SoftDeletes;
    use ExtendedSluggable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'page_title', 'slug', 'meta_tag_keywords', 'meta_tag_description',
    ];

    public static $routeUrl = 'brand/';

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
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\Brand");
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_FILL, config('constants.THUMB_IMAGE.WIDTH'), config('constants.THUMB_IMAGE.HEIGHT'))
            ->background('white')
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->fit(Manipulations::FIT_FILL, config('constants.MEDIUM_IMAGE.WIDTH'), config('constants.MEDIUM_IMAGE.HEIGHT'))
            ->background('white')
            ->nonQueued();
    }

    public function setPageTitleAttribute($value)
    {
        if (empty($value)) {
            $value = $this->name;
        }
        $this->attributes['page_title'] = $value;
    }

    public static function brandList()
    {
        return Brand::pluck('name', 'id');
    }
}
