<?php

namespace Tests\Model;

use PHPUnit\Framework\TestCase;
use App\Products\Products;
use Test\Concerns\SeedSites;

class ProductModelTest extends TestCase
{
	use SeedSites;

	public function setUp() : void
	{
		$this->setUpDb();
		$this->insertTableData();
	}

	/*public function testFindByIDAssetsToTrue()
	{	
		$model = new Products();
		$this->assertIsArray($model->findCustomerByID(1));
	}

	public function testFindByIDAssertEmptyResult()
	{
		$model = new Products();
		$this->assertEmpty($model->findCustomerByID(11));
	}*/
}
