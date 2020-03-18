<?php

namespace App\Validation;

class Price implements ValidationInterface
{
	/**
	* Check if price is within the requirement 
    *
    * @return float
    */	
	public function priceCheck(float $price) : float
	{
		if ($price || $price === null || $price < 1) {
			throw new Exception("Please try again",1);
		}	

		return $price;
	}

	public function maxPrice(float $price, float $max) : float
	{
		if ($price >= $max) {
			throw new Exception("Please try again",1);
		}	

		return $price;
	}  

	public function isValid(int $strict, array $ruleset, $input) : bool
	{
		if ($strict === 1) {

			if (!$this->whiteList($currency) || !$this->maxPrice()) {
				return false;
			};
			
			return true;
		}

		
	}


}
