<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerGroup extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function attributeOptions()
    {
        return $this->hasMany('App\User');
    }
}
