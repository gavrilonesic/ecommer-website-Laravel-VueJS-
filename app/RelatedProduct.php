<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatedProduct extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'related_product_id',
    ];

    public $timestamps = false;
}
