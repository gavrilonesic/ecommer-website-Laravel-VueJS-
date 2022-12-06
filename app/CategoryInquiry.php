<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryInquiry extends Model
{
	use \Spiritix\LadaCache\Database\LadaCacheTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id','first_name', 'last_name', 'company_name', 'email', 'phone','street_address','address_line_2','city','state','zipcode','country','process_time','temperature','concentration','soak','special_requirements','reference','comments'
    ];
}
