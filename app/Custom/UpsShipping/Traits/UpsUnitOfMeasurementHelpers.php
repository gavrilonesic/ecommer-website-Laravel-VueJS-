<?php 

namespace App\Custom\UpsShipping\Traits;

use App\Product;
use Ups\Entity\Dimensions;
use Ups\Entity\Tradeability\UnitOfMeasurement;

Trait UpsUnitOfMeasurementHelpers{

	/**
	 * Set package dimensions
	 * 
	 * @param &$package
	 * @param $product 
	 */
	private function setDimensions(&$package, $width, $height, $length)
	{
		// set package dimension
		$width = round($width);
		$height = round($height);
		$length = round($length);

		$height = $height <= 0 ? 1 : $height;
		$width = $width <= 0 ? 1 : $width;
		$length = $length <= 0 ? 1 : $length;

		$dimensions = new Dimensions();
        $dimensions->setHeight($height);
        $dimensions->setWidth($width);
        $dimensions->setLength($length);

        $unit = new UnitOfMeasurement();
        $unit->setCode(UnitOfMeasurement::UOM_IN);
        $dimensions->setUnitOfMeasurement($unit);

        $package->setDimensions($dimensions);
	}

	/**
	 * Set package weight
	 * 
	 * @param &$package
	 * @param float $product
	 */
	private function setWeight(&$package, $weight)
	{
		// set package weight
		$weight = round($weight);
		
		// we can't send a package with 0lbs
		if ($weight <= 0) {
			$weight = 1;
		}

        $package->getPackageWeight()->setWeight($weight);
        $package->getPackageWeight()->setUnitOfMeasurement(
        	( new UnitOfMeasurement )->setCode(UnitOfMeasurement::UOM_LBS)
        );
	}
}