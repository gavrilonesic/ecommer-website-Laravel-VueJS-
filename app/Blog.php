<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Blog extends Model implements HasMedia
{
    use SoftDeletes;
    use HasMediaTrait;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'title', 'short_description', 'description', 'image', 'blog_category_id', 'blog_category_name', 'page_title', 'meta_tag_keywords', 'meta_tag_description', 'status'];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_FILL, config('constants.THUMB_IMAGE.WIDTH'), config('constants.THUMB_IMAGE.HEIGHT'))
            ->background('white')->nonQueued();

        $this->addMediaConversion('medium')
            ->fit(Manipulations::FIT_FILL, config('constants.MEDIUM_IMAGE.WIDTH'), config('constants.MEDIUM_IMAGE.HEIGHT'))
            ->background('white')->nonQueued();
    }
}
