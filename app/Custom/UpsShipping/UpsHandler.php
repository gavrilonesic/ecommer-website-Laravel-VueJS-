<?php

namespace App\Custom\UpsShipping;

use App\{ Order, CartStorage };
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ups\Entity\AddressValidationResponse;
use Ups\Entity\AddressValidation\AVAddress;
use App\Custom\UpsShipping\Repositories\UpsShippingRepository;

class UpsHandler
{
	/**
	 * Address Validation Response
	 * 
	 * @var AddressValidationResponse
	 */
	protected $validationResponse;

	/**
	 * Customer address
	 * 
	 * @var Address
	 */
	protected $address;

	/**
	 * UPS repository
	 * 
	 * @var UPS Shipping Repository
	 */
	protected $upsRepository;

	/**
	 * Cart Repository
	 * 
	 * @var CartRepositoryInterface
	 */
	protected $cartRepository;

	/**
	 * Courier model
	 * 
	 * @var Courier
	 */
	protected $courier;
	
	/**
	 * Order model
	 * 
	 * @var Order
	 */
	protected $order;
	
	/**
	 * UPS Shipping cost constructor
	 */
	public function __construct(UpsShippingRepository $upsRepository)
	{
		$this->validationResponse = null;
		$this->upsRepository 	  = $upsRepository;
	}

	/**
	 * Set Courier
	 * 
	 * @param Courier $courier
	 */
	public function setCourier($courier)
	{
		$this->courier = $courier;

		$this->upsRepository->setService($courier);

		return $this;
	}
	
	/**
	 * Set Order
	 * 
	 * @param Order $order
	 */
	public function setOrder(Order $order)
	{
		$this->order = $order;

		return $this;
	}

	/**
	 * Get Courier
	 * 
	 * @return Courier
	 */
	public function getCourier()
	{
		return $this->courier;
	}

	/**
	 * Get Order
	 * 
	 * @return Order
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * Validate address
	 */
	public function validate()
	{
		return tap($this->upsRepository->validateAddress()->getAddressValidationResult(), function($validationResponse){
			$this->validationResponse = $validationResponse;
		});
	}

	/**
	 * Set customer address on ups repository
	 * We can forward calls to repo class
	 * 
	 * @param Address $address
	 */
	public function setAddress($address = null)
	{
		if (!is_null($address) && $address instanceof Address) {
			$this->apiAddress = $address;
		}

		$this->upsRepository->setCustomerAddress($this->apiAddress);

		return $this;
	}

	/**
	 * Apply returned address to customer address
	 */
	public function applyValidatedAddress(AVAddress $validAddress = null)
	{
		if (!$this->validationResponse instanceof AddressValidationResponse) {
			return false;
		}

		// get validated address from API if not set
		if (!isset($validAddress) || !$validAddress instanceof AVAddress) {
			$validAddress = $this->validationResponse->getValidatedAddress();
		}

		// we don't need to set is_valid col to fillable
		// it's more secure to update it manually 
		$this->apiAddress->is_valid = true;
		$this->apiAddress->classification = $validAddress->addressClassification->description->__toString();

		if (strtolower($this->apiAddress->city->name) != strtolower($validAddress->politicalDivision2)) {
			try {
				$city = City::whereName($validAddress->politicalDivision2)->firstOrFail();
				$this->apiAddress->city()->associate($city);
			} catch (\Exception $e) {

			}
		}

		if (strtolower($this->apiAddress->province->abv) != strtolower($validAddress->politicalDivision1)) {
			try {
				$state = Province::whereAbv($validAddress->politicalDivision1)->firstOrFail();
				$this->apiAddress->province()->associate($state);
			} catch (\Exception $e) {

			}
		}

		if ($this->apiAddress->zip != $validAddress->postcodePrimaryLow) {
			$this->apiAddress->zip = $validAddress->postcodePrimaryLow;
		}

		$this->apiAddress->post_code_extended_low = $validAddress->postcodeExtendedLow;

		return $this->apiAddress->save();
	}

	/**
	 * initialize ups repository data
	 * 
	 * @return $this
	 */
	public function initUpsRepository(Request $request)
	{
		return tap($this, function($upsHandler) use ($request) {
			$upsHandler->upsRepository->setShipment()
				->setShipperAddress()
				->setShipFromAddress()
				->setCustomerAddress($request->session()->get('shipping_details'))
				->validateAddress();
        });
	}

	/**
	 * Get validation response
	 * 
	 * @return mixed
	 */
	public function getValidationResponse()
	{
		return $this->validationResponse;
	}

	/**
	 * Get products cost
	 * 
	 * @param  Collection $products
	 * @return int
	 */
	public function getProductsShippingCost(Collection $products)
	{
		if (is_null($this->courier)) {
			return false;
		}
         
		$totalCharge = $this->upsRepository->addPackages($products)->requestRates()->getTotalCharge();

		$totalCharge *= $this->courier->markup ?? 1;

		return round($totalCharge, 2);
	}

	/**
	 * Get shipping cost
	 * 
	 * @return float
	 */
	public function getCost(Request $request)
	{
        $shippingDetails = $request->session()->get('shipping_details');

		// Get Products
        // Determine if free shipping is available
        // Determine LTL
        // get order total
        
		// Add products
		$products = CartStorage::getCart();
		$rates = $this->upsRepository->addPackages($products)->requestRates();

		$totalCharge = $rates->getTotalCharge();

        // Markup, if necessary
        // $totalCharge *= $this->courier->markup ?? 1;

		return round($totalCharge, 2);
	}
}