<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'iso3', 'iso2', 'phone_code', 'capital', 'currency',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function states()
    {
        return $this->hasMany('App\State');
    }
}
