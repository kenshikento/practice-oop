<?php

namespace App\Validation;

use App\Customers\Customer as CustomerModel;

class Customer implements ValidationInterface
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

	public function email(string $email) : bool
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->errors[] = 'Invalid email format';
			return false;
		}
		return true;
	}  

	public function uniqueEmail(string $email) : bool
	{
		$customer = new CustomerModel();
		if ($customer->findCustomerByEmail($email)->exist()) {
			$this->errors[] = 'Email Already Exists';
			return false;
		}

		return true;
	}

	// Just simple way checking person age 
	public function age(string $age)
	{
		if (\Carbon\Carbon::createFromFormat('d-m-Y', $age)->age < 18) {
			$this->errors[] = 'need to be 18 and over';
			return false;
		}

		return true;
	}

	public function isValid(bool $strict, $input) : bool
	{
		$name = $input['name'];
		$email = $input['email'];
		$age = $input['age'];

		if ($strict === true) {

			if ( !$this->inputs([$name, $email, $age])|| !$this->name($name) || !$this->email($email) || !$this->age($age) || !$this->uniqueEmail($email)) {
			
				return false;
			};

			return true;
		}

		if (!$this->email($email)) {
			return false;
		} 

		return true;
	}

	public function getErrors() 
	{
		return $this->errors;
	}
}
