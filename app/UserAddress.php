<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use \Spiritix\LadaCache\Database\LadaCacheTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'big_id', 'first_name', 'last_name', 'address_name', 'email', 'mobile_no', 'billing_type', 'address_line_1', 'address_line_2', 'city_name', 'state_id', 'country_id', 'zip_code', 'address_type', 'primary_address', 'state_name'
    ];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function getUserAddress()
    {
        $userAddress = '';
        if (!empty($this->address_line_1)) {
            $userAddress .= $this->address_line_1 . '<br/>';
        }
        if (!empty($this->address_line_2)) {
            $userAddress .= $this->address_line_2 . '<br/>';
        }
        if (!empty($this->city_name)) {
            $userAddress .= $this->city_name . ', ';
        }
        if (!empty($this->state_id)) {
            $userAddress .= $this->state->name . ' ';
        }else{
            $userAddress .= $this->state_name . ' ';
        }
        if (!empty($this->zip_code)) {
            $userAddress .= $this->zip_code . '<br/>';
        }
        if (!empty($this->country)) {
            $userAddress .= $this->country->name;
        }
        return $userAddress;

    }
}
