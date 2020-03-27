<?php

namespace App\Validation;

use App\Products\Products as ProductsModel;

class Products implements ValidationInterface
{
	public $errors;

	/**
	* allows only letter and white space
    *
    * @return bool
    */	
	public function name(string $name) : bool
	{
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			$this->errors[] = 'Only letters and white space allowed';
			return false;
		}

		return true;
	}

	public function inputs($inputs) : bool 
	{
		foreach ($inputs as $value) 
		{
			if(empty($value)) {
				$this->errors[] = 'Issue with parameter' . $value;
				return false;
			}

			return true;
		}
	}

	public function uniqueProductName(string $name) : bool
	{
		$product = new ProductsModel();
		if ($product->findProductsByName($name)->exist()) {
			$this->errors[] = 'Product Exists already';
			return false;
		}
		return true;
	}

	public function productNameDoestNotExists(string $name) : bool
	{	
		$product = new ProductsModel();
		if (!$product->findProductsByName($name)->exist()) {
			$this->errors[] = 'Product Doesnt Exists ';
			return false;
		}
		return true;
	}

	public function isValid(bool $strict = true, $input) : bool
	{
		$name = $input['name'];
		$price = $input['name'];
		$id = $input['name'] ?? null;

		if ($strict === true) {

			if ( !$this->inputs([$name, $price])|| !$this->name($name) || !$this->uniqueProductName($name)) {
			
				return false;
			};

			return true;
		}

		if ( !$this->inputs([$id, $name, $price])|| !$this->name($name) || !$this->productNameDoestNotExists($name)) {
			return false;
		};

		return true;
	}

	public function getErrors() 
	{
		return $this->errors;
	}
}
