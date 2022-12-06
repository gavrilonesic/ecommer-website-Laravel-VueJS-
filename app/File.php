<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class File extends Model implements HasMedia
{
    //
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use HasMediaTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'content', 'is_queued', 'scheduled_at', 'done_at', 'is_working',
    ];
}
