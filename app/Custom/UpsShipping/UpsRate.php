<?php

namespace App\Custom\UpsShipping;

use App\{ Model, Product, Address };
use App\Custom\UpsShipping\Repositories\UpsShippingRepository;

class UpsRate extends Model
{
	//
	protected $fillable = [
		'value', 'weight', 'weight_uom', 'address_id'
	];

	/**
	 * Get related address
	 * 
	 * @return Address
	 */
	public function address()
	{
		return $this->belongsTo(Address::class);
	}
}
