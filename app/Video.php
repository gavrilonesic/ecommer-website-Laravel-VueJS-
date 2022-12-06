<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Video extends Model implements HasMedia
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    use HasMediaTrait;

    protected $fillable = ['title'];

    public function medias()
    {
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\Video");
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_FILL, config('constants.THUMB_IMAGE.WIDTH'), config('constants.THUMB_IMAGE.HEIGHT'))
        // ->watermark(public_path('images/video-icon.png'))
        // ->watermarkOpacity(70)
        // ->watermarkHeight(config('constants.THUMB_IMAGE.HEIGHT'), Manipulations::UNIT_PIXELS)
        // ->watermarkWidth(config('constants.THUMB_IMAGE.WIDTH'), Manipulations::UNIT_PIXELS)
        // ->watermarkPosition(Manipulations::POSITION_CENTER)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->fit(Manipulations::FIT_FILL, config('constants.MEDIUM_IMAGE.WIDTH'), config('constants.MEDIUM_IMAGE.HEIGHT'))
        // ->watermark(public_path('images/video-icon.png'))
        // ->watermarkHeight(config('constants.MEDIUM_IMAGE.HEIGHT'), Manipulations::UNIT_PIXELS)
        // ->watermarkWidth(config('constants.MEDIUM_IMAGE.WIDTH'), Manipulations::UNIT_PIXELS)
        // ->watermarkOpacity(50)
        // ->watermarkPosition(Manipulations::POSITION_CENTER)
            ->nonQueued();
    }
}
