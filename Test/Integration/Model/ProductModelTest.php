<?php

namespace Tests\Integration\Model;

use PHPUnit\Framework\TestCase;
use App\Products\Products;
use App\Validation\Products as ProductsValidation;
use Symfony\Component\HttpFoundation\Request;
use Test\Concerns\SeedSites;


class ProductModelTest extends TestCase
{
	use SeedSites;

	public function setUp() : void
	{
		$this->setUpDb();
		$this->insertTableData();
		$this->model = new Products();
	}

	public function testFindByIDAssertsIsArray()
	{	
		$this->assertIsArray($this->model->findProductsById(1)->get());
	}

	public function testFindByIDAssertEmptyResult()
	{
		$this->assertEmpty($this->model->findProductsById(50)->get());
	}

	public function testFindProductsByNameAssertsIsArray()
	{
		$this->assertIsArray($this->model->findProductsByName('test')->get());
	}

	public function testFindProductsByNameAssertsEmptyArray()
	{
		$this->assertEmpty($this->model->findProductsByName('test1321')->get()); // Need confirm that this name isn't in db
	}

	public function testInsertProductsAssertTrue()
	{
		$faker = \Faker\Factory::create();

		$data = [
				'id' => 1,
		    	'name' 	=> 'FabientheProduct',
		    	'price' => 12
		];

		$test = $this->model->addProducts($data);

		$this->assertTrue($test);
	}

	public function testInsertProductsAssertFalse() 
	{
		$data = [
				'id' => 1,
		    	'name' 	=> 'test',
		    	'age'   => 12
		];

		$value = $this->model->addProducts($data);
		$this->assertFalse($value);
	}

	public function testUpdateCustomerAssertToTrue()
	{
		$data = [
		    	'id'	=> 1,
		    	'name' 	=> 'test',
		    	'price' => 10,
		];

		$value = $this->model->updateProducts($data);

		$this->assertTrue($value);
	}

	public function testUpdateCustomerAssertToFalse()
	{
		$data = [
		    	'id'	=> 1,
		    	'name' 	=> 'testsss',
		    	'price' => 10,
		];

		$value = $this->model->updateProducts($data);

		$this->assertFalse($value);
	}

	public function testDeleteProductByIdAndNameAssertToTrue()
	{
		$this->assertTrue($this->model->deleteProducts(1,'test'));
	}

	public function testDeleteProductByIdAndNameAssertToFalse()
	{
		$this->assertFalse($this->model->deleteProducts(1,'testerwe'));
	}
}