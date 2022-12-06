<?php
namespace App\Traits;

use App\RedirectUrl;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable as LibSluggable;
trait ExtendedSluggable
{
    use LibSluggable;

    public static function bootExtendedSluggable()
    {
        static::updating(function ($model) {
            if ($model->isDirty('slug') && $model->getOriginal('slug')) {
                $oldUrl = $model::$routeUrl . $model->getOriginal('slug');
                $newUrl = $model::$routeUrl . $model->slug;
                $model->setAttribute('slug', SlugService::createSlug($model, 'slug', $model->getAttribute('slug')));
                RedirectUrl::deleteOrCreate($oldUrl, $newUrl);
            }
        });
    }
}
