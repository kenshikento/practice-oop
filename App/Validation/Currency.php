<?php

namespace App\Validation;

class Currency implements ValidationInterface
{
	/**
	* Checks if Currency name matches to the white list array
    *
    * @return String
    */			
	public function whiteList(string $currency) : string
	{				
		$whitelist = ['GBR','KRW','USD','VND','CNY'];		

		if (in_array($currency,$whitelist)) {
			return $currency;
		}

		return false;																	
	}

	/**
	* Check all validation methods to see if return is valid
    *
    * @return bool
    */	
	public function isValid(bool $strict, $input, ?array $ruleset) : bool
	{
		if (!$this->whiteList($input)) {
			return false;
		};

		return true;
	}
}
