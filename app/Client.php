<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Client extends Model implements HasMedia
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use HasMediaTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'image_src', 'active', 'order'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->orderByRaw('`order` = 0, `order`');
        });
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('clients')->singleFile();
    }
}
