<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id', 'country_code', 'state_code',
    ];

    public function country() {
        return $this->belongsTo('App\Country');
    }
}
