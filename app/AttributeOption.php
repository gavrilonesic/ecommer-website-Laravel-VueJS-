<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeOption extends Model
{
    use SoftDeletes;
    use Sluggable;
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attribute_id', 'option', 'hazmat_multiplier', 'hazmat_fee'
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function productSkuValues()
    {
        return $this->hasMany('App\ProductSkuValue');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'option',
            ],
        ];
    }

    /**
     * @param  mixed $value
     * @return int
     */
    public function getHazmatMultiplierAttribute($value)
    {
        return (int) $value > 0 ? (int) $value : 1;
    }

    /**
     * @param  mixed $value
     * @return int
     */
    public function getHazmatFeeAttribute($value)
    {
        return floatval($value);
    }
}
