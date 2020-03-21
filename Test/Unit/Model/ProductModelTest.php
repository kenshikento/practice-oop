<?php

namespace Tests\Model;

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
	}

	public function testFindByIDAssertsIsArray()
	{	
		$model = new Products();
		$this->assertIsArray($model->findProductsById(1)->get());
	}

	public function testFindByIDAssertEmptyResult()
	{
		$model = new Products();
		$this->assertEmpty($model->findProductsById(50)->get());
	}

	public function testFindProductsByNameAssertsIsArray()
	{
		$model = new Products();
		$this->assertIsArray($model->findProductsByName('test')->get());
	}

	public function testFindProductsByNameAssertsEmptyArray()
	{
		$model = new Products();
		$this->assertEmpty($model->findProductsByName('test1321')->get()); // Need confirm that this name isn't in db
	}

	public function testInsertProductsAssertTrue()
	{
		$faker = \Faker\Factory::create();

		$request = Request::create(
		    '/hello-world',
		    'Post',
		    [
		    	'name' 	=> 'FabientheProduct',
		    	'price' => 12
			]
		);

		$model = new Products();
		$test = $model->addProducts($request);

		$this->assertTrue($test);
	}

	public function testInsertProductsAssertFalse() 
	{
		$request = Request::create(
		    '/hello-world',
		    'Post',
		    [
		    	'name' 	=> 'test',
		    	'age'   => 12
			]
		);

		$model = new Products();
		$value = $model->addProducts($request);
		$this->assertFalse($value);
	}


	// update 
	public function testUpdateCustomerAssertToTrue()
	{
		$request = Request::create(
		    '/hello-world',
		    'Post',
		    [
		    	'id'	=> 1,
		    	'name' 	=> 'test',
		    	'price' => 10,
			]
		);
		$validation = new ProductsValidation();
		$run_function = new Products($validation);

		$value = $run_function->updateProducts($request);

		$this->assertTrue($value);
	}

	public function testUpdateCustomerAssertToFalse()
	{
		$request = Request::create(
		    '/hello-world',
		    'Post',
		    [
		    	'id'	=> 1,
		    	'name' 	=> 'testsss',
		    	'price' => 10,
			]
		);
		$validation = new ProductsValidation();
		$run_function = new Products($validation);

		$value = $run_function->updateProducts($request);

		$this->assertFalse($value);
	}

	public function testDeleteCustomerByIdAndNameAssertToTrue()
	{
		$model = new Products();

		$this->assertTrue($model->deleteProducts(1,'test'));
	}

	public function testDeleteCustomerByIdAndNameAssertToFalse()
	{
		$model = new Products();

		$this->assertFalse($model->deleteProducts(1,'testerwe'));
	}
}