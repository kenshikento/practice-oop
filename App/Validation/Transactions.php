<?php

namespace App\Validation;

use App\Customers\Customer;

class Transactions implements ValidationInterface
{		
	/**
	* Check if Array index passes && Checks if both values product id and quanity same amount 
    *
    * @return bool
    */	
	public function matchProducts(Array $data) : bool
	{				
		if (!array_key_exists('productsID', $data) ||  !array_key_exists('totalItems', $data)) {
			$this->errors[] = 'index does not exists';
			return false;
		}

		if (count($data['productsID']) != count($data['totalItems'])) {
			$this->errors[] = 'products and quantity of items do not match';
			return false;
		}
		
		return true;																	
	}

	/**
	* Check all if any value is passed && if customer exists in DB
    *
    * @return bool
    */	
	public function customerIdExists(Array $data)
	{
		if (count($data) < 1) {
			$this->errors[] = 'no customer id input';
			return false;
		}	

		$model = new Customer();
		if (!$model->findCustomerByID($data['customerID'])) {
			$this->errors[] = 'no customer id exist';
			return false;
		}
		
		return true;
	}

	/**
	* Check all validation methods to see if return is valid
    *
    * @return bool
    */	
	public function isValid(bool $strict, $input) : bool
	{
		$products = $input['products'];
		$customer = $input['customer'];

		if (!$this->matchProducts($products) || !$this->customerIdExists($customer)) {
			return false;
		};

		return true;
	}
}
