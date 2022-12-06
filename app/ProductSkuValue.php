<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSkuValue extends Model
{

    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'attribute_id', 'attribute_option_id', 'sku_id'];

    public $timestamps = false;

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }

    public function attributeOptions()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_option_id', 'id');
    }

    public function productSkus()
    {
        return $this->belongsTo(ProductSku::class, 'product_sku_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
