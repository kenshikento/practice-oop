<?php 

namespace Test\Concerns;

use App\Customers\Customer;
use App\Customers\OrderItems;
use App\Products\Products;
use App\Products\ProductOrder;
use App\Transactions\Transactions;
use Exception;
use Faker\Generator;
use Test\Concerns\DatabaseConnectionTest;
use Carbon\Carbon;

trait SeedSites
{
	/**
     * Connects to the database and return mysqli connection
     *
     * @return mysqli
     */
	public function setUpDbConnection() 
	{
		$db = new DatabaseConnectionTest();
		$con = $db->dbconnection();
		return $con;
	}

    /**
     * Grabs the Database Name
     * [Shouldn't really need this method as it should be retrieved through ENV file]
     * 
     * @return string
     */
	public function getDbName() : string
	{
		$db = new DatabaseConnectionTest();
		$name = $db->getDbName();
		return $name;
	}

	/**
     * Creates core of tables 
     * [TODO: Transaction tables]
     * @return void
     */
	public function createTables($con) : void
	{
		$customerTable = new Customer();
		$customerTableName = $customerTable->getTableName();
		$con->select_db("tutorial"); //Need to make ENV File where it can make this

		$sql = "CREATE TABLE " . $customerTableName ."(
   			ID int NOT NULL AUTO_INCREMENT,
    		Name varchar(255) NOT NULL,
    		Age varchar(225),
    		Email varchar(255),
    		PRIMARY KEY (ID)
		)";

		if (!mysqli_query($con, $sql)) {
			throw new Exception('Something went wrong ' . $customerTableName . ' table');
		}

		$productTable = new Products();
		$productTableName = $productTable->getTableName();

		$sql = "CREATE TABLE " . $productTableName ."(
   			ID int NOT NULL AUTO_INCREMENT,
    		Name varchar(255) NOT NULL,
    		Price Decimal(6, 2), 
    		PRIMARY KEY (ID)    		
		)";

		if (!mysqli_query($con, $sql)) {
			throw new Exception('Something went wrong ' . $productTableName . ' table');
		}

		$orderItems = new OrderItems();
		$ordeItemName = $orderItems->getTableName();

		$sql = "CREATE TABLE " . $ordeItemName . " (
   			ID int NOT NULL AUTO_INCREMENT,
    		Date DATETIME, 
    		CustomerID int,
    		PRIMARY KEY (ID),
    		FOREIGN KEY(CustomerID) REFERENCES Customer(ID) ON DELETE CASCADE
		)";

		if (!mysqli_query($con, $sql)) {
			throw new Exception('Something went wrong ' . $productTableName . ' table');
		}


		$productTransaction = new ProductOrder();
		$productTransactionName = $productTransaction->getTableName();

		$sql = "CREATE TABLE " . $productTransactionName . " (
   			ID int NOT NULL AUTO_INCREMENT,
   			Quantity int,
    		ProductID int,
    		PRIMARY KEY (ID),
    		FOREIGN KEY(ProductID) REFERENCES Products(ID) ON DELETE CASCADE
		)";

		if (!mysqli_query($con, $sql)) {
			throw new Exception('Something went wrong ' . $productTransactionName . ' table');
		}

 		$transactionsTable = new Transactions();
		$transactionsTableName = $transactionsTable->getTableName();

		$sql = "CREATE TABLE " . $transactionsTableName . " (
   			ID int NOT NULL AUTO_INCREMENT,
    		ProductsTransactionID int, 
    		OrderItemsID int,
    		PRIMARY KEY (ID),
    		FOREIGN KEY(ProductsTransactionID) REFERENCES orderitems(ID) ON DELETE CASCADE,
    		FOREIGN KEY(OrderItemsID) REFERENCES producttransaction(ID) ON DELETE CASCADE
		)";

		if (!mysqli_query($con, $sql)) {
			throw new Exception('Something went wrong ' . $transactionsTableName . ' table');
		}
	}

	/**
     * Inserts Data for customer and product 
     * 
     * @return void
     */
	public function insertTableData() : void
	{	
		$con = $this->setUpDbConnection();

		$this->insertDummyDataforCustomer($con, 10);
		$this->insertDummyDataforProduct($con, 10);
		$this->insertDummyDataforOrderItems($con, 10);
		$this->insertDummyDataforProductTransactions($con, 10);
		$this->insertDummyDataforTransaction($con, 10);
	}

	/**
     * Inserts Data Customer 
     * 
     * @return void
     */
	public function insertDummyDataforCustomer($con, int $numberofCustomer) : void 
	{
		$faker = \Faker\Factory::create();
		$sql = "";
		$i = 0;

		$sql .= "
				INSERT INTO customer(Name, Age, Email) 
				VALUES 
					('test'," . $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)->format('Y-m-d') .",'test@hotmail.co.uk'); "
		;

		while ( $i < $numberofCustomer ) {
			$i++;
			$sql .= "
				INSERT INTO customer(Name, Age, Email) 
				VALUES 
					('". $faker->name . "', ". $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)->format('Y-m-d') .", '". $faker->email ."'); "
			;
		}
		
		mysqli_multi_query($con, $sql) or die("MySQL Error: " . mysqli_error($con) . "<hr>\nQuery: $sql");
		
		$this->clearStoredResults($con);
	}

	/**
     * Inserts Data Product 
     * 
     * @return void
     */
	public function insertDummyDataforProduct($con, int $numberofProduct) : void 
	{	
		$faker = \Faker\Factory::create();
		$sql = "";
		$i = 0;
		
		$sql .= "
				INSERT INTO products (Name, Price) 
				VALUES 
					('". 'test' . "', ". $faker->randomDigitNotNull() ."); "
		;

		while ( $i < $numberofProduct ) {
			$i++;
			$sql .= "
				INSERT INTO products (Name, Price) 
				VALUES 
					('". $faker->name . "', ". $faker->randomDigitNotNull() ."); "
			;
		}

  		mysqli_multi_query($con, $sql) or die("MySQL Error: " . mysqli_error($con) . "<hr>\nQuery: $sql");

  		$this->clearStoredResults($con);
	}

	/**
     * Inserts Data OrderItems 
     * 
     * @return void
     */
	public function insertDummyDataforOrderItems($con, int $numberofItems) : void
	{	
		$faker = \Faker\Factory::create();
		$sql = "";
		$i = 0;

		$sql .= "
				INSERT INTO orderitems (`CustomerID`,`date`)
				VALUES 
					(".  1 .", NOW());"
		;

		while ( $i < $numberofItems ) {
			$i++;
			$sql .= "
					INSERT INTO orderitems (`CustomerID`,`date`)
					VALUES 
						(".  rand(1,10) .", NOW());"
			;
		}

		mysqli_multi_query($con, $sql) or die("MySQL Error: " . mysqli_error($con) . "<hr>\nQuery: $sql");

		$this->clearStoredResults($con);
	}

	/**
     * Inserts Data ProductOrder 
     * 
     * @return void
     */
	public function insertDummyDataforProductTransactions($con, int $numberofItems)  : void
	{	
		$faker = \Faker\Factory::create();
		$sql = "";
		$i = 0;

		// should really get it from quantity potentially from products
		$sql .= "
				INSERT INTO producttransaction (`ProductID`,`Quantity`)
				VALUES 
					(".  1 .", " . 10 . " );"
		;

		while ( $i < $numberofItems ) {
			$i++;
			$sql .= "
					INSERT INTO producttransaction (`ProductID`,`Quantity`)
					VALUES 
						(". rand(1,10)  .", " . rand(1,3) . " );"
			;
		}

		mysqli_multi_query($con, $sql) or die("MySQL Error: " . mysqli_error($con) . "<hr>\nQuery: $sql");

		$this->clearStoredResults($con);
	}

	/**
     * Inserts Data Transactions 
     * 
     * @return void
     */
	public function insertDummyDataforTransaction($con, int $numberofItems) : void
	{	
		$faker = \Faker\Factory::create();
		$sql = "";
		$i = 0;

		$sql .= "
				INSERT INTO transactions (`ProductsTransactionID`, `OrderItemsID`)
				VALUES 
					(". 1 .",".  1 ."); "
		;

		while ( $i < $numberofItems ) {
			$i++;
			$sql .= "
					INSERT INTO transactions (`ProductsTransactionID`, `OrderItemsID`)
					VALUES 
						(". rand(1, $numberofItems) .",".  rand(1, $numberofItems) ."); "
			;
		}

		mysqli_multi_query($con, $sql) or die("MySQL Error: " . mysqli_error($con) . "<hr>\nQuery: $sql");

		$this->clearStoredResults($con);
	}

	/**
     * Released stored data within connection  || push results to next result
     * @param mysqli $con
     * @return void
     */
	public function clearStoredResults($con)
	{
		do  {
	    	if ($res = $con->store_result()) {
	       		$res->free();
	     	}
		} while ($con->more_results() && $con->next_result());        
	}

	/**
     * Wipes and creates database also creating tables
     * 
     * @return void
     */
	public function setUpDb() : void 
	{
		$con = $this->setUpDbConnection();
		$dbName = $this->getDbName();
		
		// Check if database exists 
		if ($this->doesDbExist($con)) {
			$this->resetDB($con, $dbName);
		}

		// In theory should remove all local version of DB and Emptying out the contents
		$this->createDb($con, $dbName);
		$this->createTables($con, $dbName);
	}

	/**
     * Checks if database exists 
     * 
     * @return bool
     */
	public function doesDbExist($mySqli) : bool
	{
		if (!empty(mysqli_fetch_array(mysqli_query($mySqli,"SHOW DATABASES LIKE 'Tutorial' ")))) {
			return true; 
		} 

		return false;		
	}	

	/**
     * Drops database 
     * 
     * @return void
     */
	public function resetDB($con, string $dbName) : void
	{
		$sql = "DROP DATABASE " . $dbName;
		if (!mysqli_query($con, $sql)) {
			throw new Exception('Something went wrong fds');
		}
	}

	/**
     * Creates database 
     * 
     * @return void
     */
	public function createDb($con, string $dbName) : void 
	{
		$sql = "CREATE  DATABASE " . $dbName;
		if (!mysqli_query($con, $sql)) {
			throw new Exception('Something went wrong fdss');
		}
	}
}