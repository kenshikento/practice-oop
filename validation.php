<?php

	class validation
	{
			
			public function currentvalidation($currency) 
				{				
					
					$whitelist = array('GBR','KRW','USD','VND','CNY');		
			
						if(!in_array($currency,$whitelist))
						{
							throw new Exception("Please try another currency",1);
						}
						else 
						{
							return $currency;
						}
					
						
				}
			public function pricevalidation($price)
				{
					if($price < 0)
						{
							throw new Exception("Please try again",1);
						}				
					else if($price > 100)
						{
							throw new Exception("Please try again max is 100",1);
						}						
						else 
						{
							return $price;
						}
				}
	
	}





?> 

