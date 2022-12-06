<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class CmsPage extends Model implements HasMedia
{
    //
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use HasMediaTrait;
    use SoftDeletes;
    use Sluggable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'page_title', 'meta_tag_keywords', 'meta_tag_description', 'status',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
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

    public function setPageTitleAttribute($value)
    {
        if (empty($value)) {
            $value = $this->title;
        }
        $this->attributes['page_title'] = $value;
    }

    public function medias()
    {
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\CmsPage");
    }
}
