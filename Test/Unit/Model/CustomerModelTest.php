<?php

namespace Tests\Model;

use PHPUnit\Framework\TestCase;
use App\Customers\Customer;
use Test\Concerns\SeedSites;
use Symfony\Component\HttpFoundation\Request;

class CustomerModelTest extends TestCase
{
	use SeedSites;

	public function setUp() : void
	{
		$this->setUpDb();
		$this->insertTableData();
	}

	public function testFindByIDAssetsToTrue()
	{	
		$model = new Customer();
		$this->assertIsArray($model->findCustomerByID(1)->get());
	}

	public function testFindByIDAssertEmptyResult()
	{

		$model = new Customer();
		$this->assertEmpty($model->findCustomerByID(12)->get());
	}

	public function testInsertCustomerAssertToTrue() 
	{
		$request = Request::create(
		    '/hello-world',
		    'Post',
		    [
		    	'name' 	=> 'Fabien',
		    	'email' => 'randAssEmail@hotmail.co.uk',
		    	'age'   => '25-02-1993'
			]
		);

		$customer = new Customer();
		$test = $customer->addCustomer($request);

		$this->assertTrue($test);
	}

	public function testInsertCustomerAssertTofalse() 
	{
		$request = Request::create(
		    '/hello-world',
		    'Post',
		    [
		    	'name' 	=> 'Fabien',
		    	'email' => 'test@hotmail.co.uk',
		    	'age'   => '25-02-1993'
			]
		);

		$customer = new Customer();
		$test = $customer->addCustomer($request);
		$this->assertFalse($test);
	}
}
