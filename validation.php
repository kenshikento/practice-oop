<?php

	class validation
	{
	    	/**
		* Checks if Currency name matches to the white list array
	        *
	        * @return String
	        */			
			public function currentvalidation(string $currency) 
			{				
				$whitelist = array('GBR','KRW','USD','VND','CNY');		
			
				if (!in_array($currency,$whitelist)) {
					throw new Exception("Please try another currency",1);
				}

				return $currency;																
			}

	    	/**
		* Check if price is within the requirement 
	        *
	        * @return String
	        */	
			public function pricevalidation(float $price)
			{
				if ($price || $price === null || $price < 1) {
					throw new Exception("Please try again",1);
				}

				if($price > 100)
				{
					throw new Exception("Please try again max is 100",1);
				}	

				return $price;
			}
	
	}


