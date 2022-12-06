<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeCategory extends Model
{
    //
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attribute_id', 'category_id', 'product_count',
    ];

    public $table = "attribute_category";
}
