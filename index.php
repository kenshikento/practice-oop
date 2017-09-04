<?php 
	include ('database.php');
	include ('validation.php');
	class payments 
	{		
		public $conn;
		public $currentvali;
		public function __construct()
		{
			$dbconnection = new Database();
			$this->conn=$dbconnection->dbconnection();
		}
		
		public function checkUser($username,$pwd)
		{
			$sql ="SELECT * FROM user WHERE username='$username' and pwd ='$pwd'";
			
			$query= $this->conn->query($sql);
			if($query->num_rows>0)
			{
				echo "Succesful";
			} 
			else
			{
				echo ("Failed Please type again");
			}
		}
		public function getTransaction($id)
		{
			$sql ="SELECT products.productname AS Productname, transaction.price AS Price, transaction.currency AS Currency,transaction.status AS Status FROM products,transaction WHERE transaction.userid='$id'";
		
			$query = $this->conn->query($sql);
			
			while ($r = mysqli_fetch_assoc($query))
				{
					$rows[]=$r;
				}
			print json_encode($rows);
		}
		public function addTransaction($price,$currency,$productid,$userid)
		{			
	
				$validation = new validation();	
				$pricevali=$validation->pricevalidation($price);	
				$currentvali=$validation->currentvalidation($currency);	
					
				$sql ="INSERT INTO transaction (price,currency,status,date,productid,userid)VALUES ($pricevali,'$currentvali','Pending',now(),$productid,$userid)";
			
				$query = $this->conn->query($sql);
				if($this->conn->query($sql))
					{
							echo "Succesfully added product <br>";
					}
					else
					{
							echo "Failed added product";
					}
		}
		public function updateTransaction($price,$currency,$status,$userid,$transactionid)
		{
			$sql ="UPDATE transaction SET price = '$price', currency= '$currency', status = '$status' WHERE userid = '$userid' and id ='$transactionid'";
				if($this->conn->query($sql))
					{
							echo "Succesfully Updated Transaction <br>";
					}
					else
					{
							echo "Failed Update Transaction";
					}
			
		}
		public function deleteTransaction($userid,$transactionid)
		{
				$sql ="DELETE FROM transaction WHERE userid = '$userid' and id ='$transactionid'";
			
				if($this->conn->query($sql))
					{
							echo "Succesfully DELETED Transaction <br>";
					}
					else
					{
							echo "Failed Delete Transaction";
					}
		}
		
		public function testValidation($price,$currency,$productid,$userid)
			{
							
				
			}
		//Check user
		//Get transaction
		//add transaction
		//update transaction
		//delete trasnaction
	}


	$run_function = new payments();
	//check User
	//$run_function ->checkUser('kenshikento','pwd');
	//show Transaction
	//$run_function->getTransaction(1);
	// addTransaction
	//$run_function->addTransaction(400,'KRW','1','1');
	//updateTransaction
	//$run_function->updateTransaction('121','APB','Accepted','1','1');
	//DELETE trasnaction
	//$run_function->deleteTransaction(1,1);
	//Test validation
	//$run_function->testValidation(1,'AAA','1','1');
	?>