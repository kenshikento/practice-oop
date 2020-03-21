<?php 
	
namespace App\Support;

class DatabaseConnection 
{	
	private $host ='localhost';
	private $user ='root';
	private $pwd ='';
	private $db ='tutorial';
	private $conn ='null';

	public function __construct()
	{
		$conn = new \mysqli(
			$this->host,
			$this->user,
			$this->pwd,
			$this->db
		);

		$this->conn = $conn;

		if(!$this->conn){
			throw mysqli_connect_error;
		}
	}

	public function dbconnection()
	{	
		return $this->conn; 
	}

	public function getDbName()
	{
		return $this->db;
	}
}