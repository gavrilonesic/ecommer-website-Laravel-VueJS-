<?php

namespace App\Custom\UpsShipping\SoapRequest;

use App\State;
use App\Country;
use \SoapClient;
use App\Custom\UpsShipping\Contacts\UpsSoapRequest;

class SoapFreightRatesRequest implements UpsSoapRequest
{
	/**
	 * @var array
	 */
	protected $request;

	/**
	 * @var array
	 */
	protected $cart;

	/**
	 * @var array
	 */
	protected $address;

	/**
	 * @var array
	 */
	protected $service;

	/**
	 * SoapRequest
	 */
	public function __construct(array $cart, array $address, array $service)
	{
		$this->cart = $cart;
		$this->address = $address;
		$this->service = $service;
	}

	/**
	 * @param array $service
	 */
	public function setService(array $service) 
	{
		$this->service = $service;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getService(): array
	{
		return $this->service;
	}

	/**
	 * @return string
	 */
	public function getServiceEndpoint(): string 
	{
		return 'ProcessFreightRate';
	}

	/**
	 * @return array
	 */
	protected function getShipFrom()
	{
        return [
        	'Name' => config('app.name'),
        	'Address' => [
        		'AddressLine' => '12336 EMERSON DR',
        		'City' => 'BRIGHTON',
        		'StateProvinceCode' => 'MI',
        		'PostalCode' => '48116',
        		'CountryCode' => 'US'
        	]
        ];
	}

	/**
	 * @return array
	 */
	protected function getShipTo()
	{
		if (isset($this->address['state_id']) && (int) $this->address['state_id'] > 0) {
			$state = State::where('id', $this->address['state_id'] ?? '')->firstOrFail();
		}

		$country = Country::where('id', $this->address['country_id'] ?? '')->firstOrFail();
		$zip = explode('-', $this->address['zip_code']);

		$address = [
    		'AddressLine' => $this->address['address_line_1'],
    		'City' => $this->address['city_name'],
    		'StateProvinceCode' => strtoupper($state->state_code ?? $this->address['state_name'] ?? ''),
    		'PostalCode' => $zip[0],
    		'PostcodePrimaryLow' => $zip[0],
    		'CountryCode' => $country->iso2,
    		'ShipperNumber' => '3625X1'
    	];

    	if (isset($zip[1]) && trim($zip[1]) !== '') {
        	$address['PostcodeExtendedLow'] = $zip[1];
        }

        return [
        	'Name' => $this->address['first_name'] . ' ' . $this->address['last_name'],
        	'Address' => $address
        ];
	}


	protected function getMappedProducts()
	{
		return collect($this->cart['cart'])
		->transform(function($cartItem) {
			return (Object) $cartItem;
		})
		->map(function($cartItem) {

			$weight = floatval($cartItem->attributes['weight']) > 0 ? $cartItem->attributes['weight'] : 600;
			$length = floatval($cartItem->attributes['length']) > 0 ? $cartItem->attributes['length'] : 34;
			$width = floatval($cartItem->attributes['width']) > 0 ? $cartItem->attributes['width'] : 23;
			$height = floatval($cartItem->attributes['height']) > 0 ? $cartItem->attributes['height'] : 23;

			return [
	    		'CommodityID' => '',
	    		'Description' => 'No Description',
	    		'Weight' => [
	    			'UnitOfMeasurement' => [
		                'Code' => 'LBS',
		                'Description' => 'Pounds'
		            ],
		            'Value' => ($weight ?? 9) * $cartItem->quantity
	    		],
	    		'Dimensions' => [
	    			'UnitOfMeasurement' => [
		                'Code' => 'IN',
		                'Description' => 'Inches'
		            ],
		            'Length' => $length ?? 9,
		            'Width' => $width ?? 9,
		            'Height' => $height ?? 9,
	    		],
	    		'NumberOfPieces' => '1',
	    		'PackagingType' => [
	    			'Code' => 'BAG',
		          	'Description' => 'BAG'
		       	],
		       	'DangerousGoodsIndicator' => '',
		       	'CommodityValue' => [
		     		'CurrencyCode' => 'USD',
		           	'MonetaryValue' => $cartItem->price * $cartItem->quantity
		       	],
		       	'FreightClass' => '60',
	    	];
		})
		->values()
		->toArray();
	}


	/**
	 * @return self
	 */
	public function setRequest(): void
	{
        $this->request = [
        	'Request' => [
        		'RequestOption' => 'RateChecking Option'
        	],
        	'ShipFrom' => $this->getShipFrom(),
        	'ShipTo' => $this->getShipTo(),
        	'PaymentInformation' => [
        		'Payer' => $this->getShipFrom(),
        		'ShipmentBillingOption' => [
        			'Code' => '10',
        			'Description' => 'PREPAID'
        		]
        	],
        	'Service' => $this->getService(),
        	'HandlingUnitOne' => [
        		'Quantity' => '1',
        		'Type' => [
        			'Code' => 'PLT',
		          	'Description' => 'PALLET'
        		]	
        	],
        	'DensityEligibleIndicator' => '0',
        	'HandlingUnits' => [
        		'Quantity' => collect($this->cart['cart'])->sum('quantity'),
        		'Type' => [
        			'Code' => 'PAL',
        			'Description' => 'PALLET',
        		],
        		'Dimensions' => [
        			'Length' => 34,
        			'Width' => 23,
        			'Height' => 23,
        			'UnitOfMeasurement' => [
        				'Code' => 'IN',
		                'Description' => 'Inches'
        			]
        		],
        	],
        	'Commodity' => $this->getMappedProducts()
        ];
	}

	/**
	 * @return array
	 */
	public function getRequest(): array
	{
		$this->setRequest();

		return $this->request;
	}	
}