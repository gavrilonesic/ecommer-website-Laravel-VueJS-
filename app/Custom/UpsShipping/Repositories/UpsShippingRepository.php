<?php 

namespace App\Custom\UpsShipping\Repositories;

use App\Country;
use Ups\AddressValidation;
use App\Base\BaseRepository;
use Ups\Entity\NegotiatedRates;
use Ups\Entity\UnitOfMeasurement;
use App\{ Order, Product, State };
use Illuminate\Support\Collection;
use App\Address as CustomerAddress;
use Ups\Entity\AddressValidationResponse;
use Ups\Exception\InvalidResponseException;
use Ptondereau\LaravelUpsApi\Facades\UpsRate;
use Ups\Entity\AddressValidation\AddressClassification;
use Ptondereau\LaravelUpsApi\Facades\UpsAddressValidation;
use App\Custom\UpsShipping\Traits\UpsUnitOfMeasurementHelpers;
use Ups\Entity\{ Address, Package, Service, ShipFrom, Shipment, Dimensions, PickupType, RateRequest, RateResponse, PackagingType, RatedShipment };

class UpsShippingRepository extends BaseRepository
{
	use UpsUnitOfMeasurementHelpers;

	/**
	 * Max weight per package in lbs
	 */
	const MAX_PACKAGE_WEIGHT = 150;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->shipment = new Shipment();
	}

	/**
	 * Shipment type
	 * 
	 * @var Ups\Entity\Shipment
	 */
	protected $shipment;

	/**
	 * Customer address
	 * 
	 * @var CustomerAddress
	 */
	protected $address;

	/**
	 * Address validation result
	 * 
	 * @var string
	 */
	protected $addressValidationResult;

	/**
	 * Error
	 * 
	 * @var \Exception
	 */
	protected $error;

	/**
	 * Shipment type
	 * 
	 * @var Ups\Entity\RateResponse
	 */
	protected $response;

	private $states = array(
		'Alabama'=>'AL',
		'Alaska'=>'AK',
		'Arizona'=>'AZ',
		'Arkansas'=>'AR',
		'California'=>'CA',
		'Colorado'=>'CO',
		'Connecticut'=>'CT',
		'Delaware'=>'DE',
		'Florida'=>'FL',
		'Georgia'=>'GA',
		'Hawaii'=>'HI',
		'Idaho'=>'ID',
		'Illinois'=>'IL',
		'Indiana'=>'IN',
		'Iowa'=>'IA',
		'Kansas'=>'KS',
		'Kentucky'=>'KY',
		'Louisiana'=>'LA',
		'Maine'=>'ME',
		'Maryland'=>'MD',
		'Massachusetts'=>'MA',
		'Michigan'=>'MI',
		'Minnesota'=>'MN',
		'Mississippi'=>'MS',
		'Missouri'=>'MO',
		'Montana'=>'MT',
		'Nebraska'=>'NE',
		'Nevada'=>'NV',
		'New Hampshire'=>'NH',
		'New Jersey'=>'NJ',
		'New Mexico'=>'NM',
		'New York'=>'NY',
		'North Carolina'=>'NC',
		'North Dakota'=>'ND',
		'Ohio'=>'OH',
		'Oklahoma'=>'OK',
		'Oregon'=>'OR',
		'Pennsylvania'=>'PA',
		'Rhode Island'=>'RI',
		'South Carolina'=>'SC',
		'South Dakota'=>'SD',
		'Tennessee'=>'TN',
		'Texas'=>'TX',
		'Utah'=>'UT',
		'Vermont'=>'VT',
		'Virginia'=>'VA',
		'Washington'=>'WA',
		'West Virginia'=>'WV',
		'Wisconsin'=>'WI',
		'Wyoming'=>'WY'
	);

	/**
	 * Set shipper address
	 */
	public function setShipperAddress()
	{
		$this->shipment->getShipper()
			->setShipperNumber('3625X1')
			->getAddress()
			->setPostalCode('48116')
        	->setAddressLine1('12336 EMERSON DR')
        	->setCity('BRIGHTON')
        	->setStateProvinceCode('MI')
        	->setCountryCode('US');

        return $this;
	}

	/**
	 * Validate customer address
	 * 
	 * @return $this
	 */
	public function validateAddress()
	{
		if (!$this->customerAddress instanceof Address) {
			throw new Exception("Customer address not set", 1);
		}

		UpsAddressValidation::activateReturnObjectOnValidate();

		$validationResult = UpsAddressValidation::validate(
			$this->customerAddress, 
			AddressValidation::REQUEST_OPTION_ADDRESS_VALIDATION_AND_CLASSIFICATION,
			$maxSuggestions = 3
		);

        if ( $validationResult instanceof AddressValidationResponse && $validationResult->getAddressClassification() instanceof AddressClassification ) {

        	$this->customerAddress->setResidentialAddressIndicator(
        		$validationResult->getAddressClassification()->description->__toString()
        	);

			$this->shipment->getShipTo()->setAddress($this->customerAddress);
        }

        $this->addressValidationResult = $validationResult;

        return $this;
	}

	/**
	 * Add packages to shipement from a given order
	 * 
	 * @param Order $order
	 */
	public function addPackages($cartData)
	{
		$cartEntries = $cartData['cart'];

        $totalWeight = 0;
        $shipment = $this->shipment;

        $packages = [];

        collect($cartEntries)->map(function($item) {
        		return (Object) $item;
        	})
        	->each(function($item) use (&$totalWeight, &$packages, $cartEntries) {

        		if (isset($item->attributes['weight'])) {
        			$weight = $item->attributes['weight'];
        		}

        		if (! isset($weight)) {
        			$product = Product::find($item->attributes['product_id']);
        			$weight = $product->weight;
        		}

				$weight = $item->quantity * ( $weight ?? 0 );
	        	
	    		// add package
	        	if ( $totalWeight > abs(self::MAX_PACKAGE_WEIGHT - $weight) && $totalWeight < self::MAX_PACKAGE_WEIGHT ) {
	        		$package = new Package();
	        		$package->getPackagingType()->setCode(PackagingType::PT_PACKAGE);
	        		$this->setWeight($package, $totalWeight);
	        		$packages[] = $package;
	        		$totalWeight = 0;
	        	}

	        	$totalWeight += $weight;
			});

        // total packges to send
		$iterations = ceil($totalWeight/self::MAX_PACKAGE_WEIGHT);

		for ($i = 0; $i < $iterations; $i++) { 

			$package = new Package();
			$package->getPackagingType()->setCode(PackagingType::PT_PACKAGE);

	        $weight = self::MAX_PACKAGE_WEIGHT;

	        // last iteration
	        if ($i == ($iterations-1)) {
	        	$weight = $totalWeight - self::MAX_PACKAGE_WEIGHT*($iterations-1);
	        }

	        if ($weight < 0) {
	        	continue;
	        }
	        
			// add product as a package
			$this->setWeight($package, $weight);
			$packages[] = $package;
		}

		$this->shipment->setPackages($packages);

        return $this;
	}

	/**
	 * Request UPS API for shipping rates
	 * 
	 * @return $this
	 */
	public function requestRates()
	{
		$this->shipment->showNegotiatedRates();

		tap(UpsRate::getRate($this->shipment), function($response){
			$this->response = $response;
		});

		return $this;
	}

	/**
	 * Set service
	 * 
	 * @param string $code
	 */
	public function setService($code = Service::S_GROUND)
	{
		try {
			$this->shipment->setService( 
				(new Service)->setCode($code)
			);
		} catch (\Exception $e) {
			$this->setError($e);			
		}
		
		return $this;
	}

	/**
	 * Address setter
	 * 
	 * @param $address
	 */
	public function setCustomerAddress($address)
	{
		if (isset($address['state_id']) && (int) $address['state_id'] > 0) {
			$state = State::where('id', $address['state_id'] ?? '')->firstOrFail();
		}

		$country = Country::where('id', $address['country_id'] ?? '')->firstOrFail();
		$zip = explode('-', $address['zip_code']);

		$shipTo = $this->shipment->getShipTo();
        $shipToAddress = $shipTo->getAddress();
    	$shipToAddress->setPostalCode($zip[0])
	    	->setAddressLine1($address['address_line_1'])
	    	->setAddressLine2($address['address_line_2'])
	    	->setPostcodePrimaryLow($zip[0])
        	->setCity($address['city_name'])
        	->setStateProvinceCode(strtoupper($state->state_code ?? $address['state_name'] ?? ''))
        	->setCountryCode($country->iso2);

        if (isset($zip[1]) && trim($zip[1]) !== '') {
        	$shipToAddress = $shipToAddress->setPostcodeExtendedLow($zip[1]);
        }

    	// address
        $this->customerAddress = $shipToAddress;

        return $this;
	}

	/**
	 * Set Ship from address
	 */
	public function setShipFromAddress()
	{
		// create address
        $address = new Address();
        $address->setPostalCode('48116')
			->setAddressLine1('12336 EMERSON DR')
			->setStreetName('12336 EMERSON')
			->setCity('BRIGHTON')
			->setStateProvinceCode('MI')
			->setCountryCode('US');

        $shipFrom = new ShipFrom();
        $shipFrom->setAddress($address);

        $this->shipment->setShipFrom($shipFrom);

       	return $this;
	}

	/**
	 * Set shipment
	 */
	public function setShipment()
	{
		$this->shipment = new Shipment();

		return $this;
	}

	/**
	 * Get Total charge
	 * 
	 * @return int
	 */
	public function getTotalCharge()
	{
		if (!$this->response instanceof RateResponse) {
			return false;
		}

		$rate = $this->response->RatedShipment;

		if (!is_array($rate)) {
			return false;
		}

		$rate = $rate[0];

		if (!$rate instanceof RatedShipment) {
			return false;
		}

		if ($rate->NegotiatedRates instanceof NegotiatedRates) {

			return round($rate->NegotiatedRates->NetSummaryCharges->GrandTotal->MonetaryValue, 2);
		}

		return round($rate->TotalCharges->MonetaryValue, 2);
	}


	/**
	 * Get API response
	 * 
	 * @return mixte
	 */
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * @return stdClass
	 */
	public function getAddressValidationResult()
	{
		return $this->addressValidationResult;
	}
}