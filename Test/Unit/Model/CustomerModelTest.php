<?php

namespace Tests\Model;

use App\Customers\Customer;
use App\Validation\Customer as CustomerValidation;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
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
		$faker = \Faker\Factory::create();

		$request = Request::create(
		    '/hello-world',
		    'Post',
		    [
		    	'name' 	=> 'Fabien',
		    	'email' => 'randAssEmail@hotmail.co.uk',
		    	'age'   => $faker->dateTimeBetween($startDate = '-100 years', $endDate = '-18 years', $timezone = null)->format('d-m-Y')
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
		$value = $customer->addCustomer($request);
		$this->assertFalse($value);
	}

	public function testUpdateCustomerAssertTotrue()
	{
		$request = Request::create(
		    '/hello-world',
		    'Post',
		    [
		    	'name' 	=> 'dsa123',
		    	'email' => 'test@hotmail.co.uk',
		    	'age'	=> '20-02-1993'
			]
		);

		$validation = new CustomerValidation();
		$run_function = new Customer($validation);

		$value = $run_function->updateCustomer($request);
		$this->assertTrue($value);
	}

	public function testUpdateCustomerAssertTofalse()
	{
		$request = Request::create(
		    '/hello-world',
		    'Post',
		    [
		    	'name' 	=> 'dsa123',
		    	'email' => 'test123@hotmail.co.uk',
		    	'age'	=> '20-02-1993'
			]
		);
		$validation = new CustomerValidation();
		$run_function = new Customer($validation);

		$value = $run_function->updateCustomer($request);

		$this->assertFalse($value);
	}

	public function testDeleteCustomerByIdAndNameAssertToTrue()
	{
		$model = new Customer();

		$this->assertTrue($model->deleteCustomer(1));
	}

	public function testDeleteCustomerByIdAndNameAssertToFalse()
	{
		$model = new Customer();

		$this->assertFalse($model->deleteCustomer(50));
	}
}
