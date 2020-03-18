<?php 

namespace Test\Concerns;

use App\Customers\Customer;
use App\Products\Products;
use Exception;
use Faker\Generator;
use Test\Concerns\DatabaseConnectionTest;

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
    		Age int,
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

		// Need do transaction tables 
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
		$this->clearStoredResults($con);
		$this->insertDummyDataforProduct($con, 10);
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
					('test',12,'test@hotmail.co.uk'); "
		;

		while ( $i < $numberofCustomer ) {
			$i++;
			$sql .= "
				INSERT INTO customer(Name, Age, Email) 
				VALUES 
					('". $faker->name . "', ". $faker->randomDigit .", '". $faker->email ."'); "
			;
		}
		
		mysqli_multi_query($con, $sql) or die("MySQL Error: " . mysqli_error($con) . "<hr>\nQuery: $sql");
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

		while ( $i < $numberofProduct ) {
			$i++;
			$sql .= "
				INSERT INTO products (Name, Price) 
				VALUES 
					('". $faker->name . "', ". $faker->randomDigitNotNull() ."); "
			;
		}

  		mysqli_multi_query($con, $sql) or die("MySQL Error: " . mysqli_error($con) . "<hr>\nQuery: $sql");
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