<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public static function customFieldList()
    {
        return CustomField::select('id', 'name')->get();
    }
}
