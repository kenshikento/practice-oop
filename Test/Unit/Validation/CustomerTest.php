<?php

namespace Tests\Validation;

use App\Validation\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
	public function setUp() : void
	{
		$this->validation = new Customer();
	}

	public function testCustomerIsValidStrictAssetsToTrue()
	{
		$data['name'] 	= 	'name';
		$data['email'] 	= 	'applebob@hotmail.com';
		$data['age'] 	=	'20-02-1993';

 		$this->assertTrue($this->validation->isValid(true, $data));
	}

	public function testCustomerIsValidStrictAssetsTofalse()
	{
		$data['name'] 	= 	'name';
		$data['email'] 	= 	'applebob@hotmail.com';
		$data['age'] 	=	'';

		$this->assertFalse($this->validation->isValid(true, $data));
	}

	public function testCustomerIsValidNotStrictAssertToTrue()
	{	
		$data['email'] 	= 	'applebob@hotmail.com';
		
		$this->assertTrue($this->validation->isValid(false, $data));
	}

	public function testCustomerIsValidNotStrictAssetsTofalse()
	{
		$data['email'] 	= 	'';
		
		$this->assertFalse($this->validation->isValid(false, $data));
	}
}
