<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Banner extends Model implements HasMedia
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
        'name', 'image', 'link', 'type', 'show_on_page', 'date_range_option', 'visibility', 'date_start', 'date_end', 'category_id', 'category_name', 'brand_id', 'brand_name', 'position', 'display_in_all_page',
    ];

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
        return $this->hasOne('App\Media', 'model_id')->where('model_type', "App\Banner");
    }

    public static function getBannerOnFront($type, $postion, $page, $id = null)
    {
        $dt      = Carbon::now();
        $banners = Self::where([['type', $type], ['position', $postion], ['visibility', 1]])
            ->where(function ($q) use ($page, $id) {
                $q->where('show_on_page', 'display_in_all_page');
                $q->orWhere(function ($query) use ($page, $id) {
                    $query->where('show_on_page', $page);
                    if (!empty($id)) {
                        $query->where('category_id', $id);
                    }
                });
            })
            ->where(function ($q) use ($dt) {
                $q->where('date_range_option', '1');
                $q->orWhere(function ($query) use ($dt) {
                    $query->where('date_range_option', 0);
                    $query->where('date_start', '>=', $dt->startOfDay());
                    $query->where('date_end', '<=', $dt->endOfDay());
                });

            })
            ->get();
        return $banners;
    }

}
