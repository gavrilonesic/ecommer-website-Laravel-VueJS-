<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'author', 'product_id', 'review_title', 'review_description', 'rating', 'status', 'publish_date','ip'];

    public function product()
    {
        return $this->belongsTo('App\Product')->withTrashed();
    }

    public function setPublishDateAttribute($value)
    {
        if (empty($value)) {
            $value = Carbon::now()->toDateString();
        }
        $this->attributes['publish_date'] = $value;
    }
}
