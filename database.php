<?php 


	class Database 
		{	
				private $host ='localhost';
				private $user ='root';
				private $pwd ='pNELhaqSPKC5MJ8L';
				private $db ='tutorial';
				private $conn ='null';
	
		public function __construct()
			{
				$conn = new mysqli($this->host,$this->user,$this->pwd,$this->db);
				$this->conn = $conn;
				if(!$this->conn){
					echo mysqli_connect_error;
				}
			}
		
		public function dbconnection ()
			{
				return $this->conn; 
			}
	
		}



?>
