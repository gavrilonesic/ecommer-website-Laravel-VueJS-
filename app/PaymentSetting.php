<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;

    protected $fillable = [
        'title', 'view', 'isFree', 'status', 'value',
    ];

    public function setValueAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['value'] = json_encode($value);
        }
    }
    public function getValueAttribute($value)
    {
        return json_decode($this->attributes['value']);
    }
}
