<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    use Sluggable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'attribute_type',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function attributeOptions()
    {
        return $this->hasMany('App\AttributeOption');
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
                'source' => 'name',
            ],
        ];
    }

    public static function attributeList()
    {
        return Attribute::pluck('name', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'attribute_category');
    }
}
