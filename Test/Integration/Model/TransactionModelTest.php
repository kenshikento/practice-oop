<?php

namespace Tests\Integration\Model;

use App\Transactions\Transactions;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Test\Concerns\SeedSites;

class TransactionModelTest extends TestCase
{
	use SeedSites;

	public function setUp() : void
	{
		$this->setUpDb();
		$this->insertTableData();
		$this->model = new Transactions();
	}

	public function testFindByIDAssetsToTrue()
	{	
		$this->assertIsArray($this->model->getOrderTransactionByCustomerID(1)->get());
	}

	public function testFindByIDAssertEmptyResult()
	{
		$this->assertEmpty($this->model->getOrderTransactionByCustomerID(12)->get());
	}

	public function testAddTransactionAssertTrue()
	{
		$data['customer']['customerID'] = 1;
		$data['products']['productsID'] = [1,2,3,4,5,6,7];
		$data['products']['totalItems'] = [7,1,2,3,4,5,6];

		$this->assertTrue($this->model->addTransaction($data));
	}

	public function testAddTransactionAssertFalse()
	{
		$data['customer']['customerID'] = 1;
		$data['products']['productsID'] = [1,1];
		$data['products']['totalItems'] = [7];

		$this->assertFalse($this->model->addTransaction($data));
	}
}
