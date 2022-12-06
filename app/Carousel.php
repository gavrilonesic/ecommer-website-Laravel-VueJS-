<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Carousel extends Model implements HasMedia
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    use HasMediaTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'heading', 'description', 'button_text', 'link',
    ];

    public function medias()
    {
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\Carousel")->where('collection_name', "carousel");
    }

    public function backgroundimg()
    {
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\Carousel")->where('collection_name', "background_carousel");
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_FILL, config('constants.THUMB_IMAGE.WIDTH'), config('constants.THUMB_IMAGE.HEIGHT'))
            ->background('white')->nonQueued();

        $this->addMediaConversion('large')
            ->fit(Manipulations::FIT_FILL, config('constants.BANNER_IMAGE.WIDTH'), config('constants.BANNER_IMAGE.HEIGHT'))
            ->background('white')->nonQueued();
    }
}
