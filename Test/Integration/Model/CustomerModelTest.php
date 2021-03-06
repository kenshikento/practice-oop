<?php

namespace Tests\Integration\Model;

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
		$this->model = new Customer();
	}

	public function testFindByIDAssetsToTrue()
	{	
		$this->assertIsArray($this->model->findCustomerByID(1)->get());
	}

	public function testFindByIDAssertEmptyResult()
	{
		$this->assertEmpty($this->model->findCustomerByID(100)->get());
	}

	public function testInsertCustomerAssertToTrue() 
	{
		$faker = \Faker\Factory::create();

		$data = [
		    	'name' 	=> 'Fabien',
		    	'email' => 'randAssEmail@hotmail.co.uk',
		    	'age'   => $faker->dateTimeBetween($startDate = '-100 years', $endDate = '-18 years', $timezone = null)->format('d-m-Y')
		];

		
		$test = $this->model->addCustomer($data);

		$this->assertTrue($test);
	}

	public function testInsertCustomerAssertTofalse() 
	{
		$data = [
		    	'name' 	=> 'Fabien',
		    	'email' => 'test@hotmail.co.uk',
		    	'age'   => '25-02-1993'
		];

		$value = $this->model->addCustomer($data);
		$this->assertFalse($value);
	}

	public function testUpdateCustomerAssertTotrue()
	{
		$data = [
		    	'name' 	=> 'dsa123',
		    	'email' => 'test@hotmail.co.uk',
		    	'age'	=> '20-02-1993'
		];

		$value = $this->model->updateCustomer($data);
		$this->assertTrue($value);
	}

	public function testUpdateCustomerAssertTofalse()
	{
		$data = [
		    	'name' 	=> 'dsa123',
		    	'email' => 'test123@hotmail.co.uk',
		    	'age'	=> '20-02-1993'
		];

		$value = $this->model->updateCustomer($data);
		$this->assertFalse($value);
	}

	public function testDeleteCustomerByIdAndNameAssertToTrue()
	{	
		$this->assertTrue($this->model->deleteCustomer(1));
	}

	public function testDeleteCustomerByIdAndNameAssertToFalse()
	{
		$this->assertFalse($this->model->deleteCustomer(50));
	}
}
