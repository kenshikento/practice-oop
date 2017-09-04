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
		
		public function checkCustomer($username,$pwd)
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
		public function getOrder($id)
		{
			$sql ="SELECT products.productname AS Productname, transaction.price AS Price, transaction.currency AS Currency,transaction.status AS Status FROM products,transaction WHERE transaction.userid='$id'";
		
			$query = $this->conn->query($sql);
			
			while ($r = mysqli_fetch_assoc($query))
				{
					$rows[]=$r;
				}
			print json_encode($rows);
		}
		public function addOrder($price,$currency,$productid,$userid)
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
		public function updateOrder($price,$currency,$status,$userid,$transactionid)
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
		public function deleteOrder($userid,$transactionid)
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
		
		
		
	}


	$run_function = new payments();
	//check User
	//$run_function ->checkCustomer('kenshikento','pwd');
	//show Transaction
	//$run_function->getOrder(1);
	// addOrder
	//$run_function->addOrder(400,'KRW','1','1');
	//updateOrder
	//$run_function->updateOrder('121','APB','Accepted','1','1');
	//DELETE trasnaction
	//$run_function->deleteOrder(1,1);
	//Test validation
	//$run_function->testValidation(1,'AAA','1','1');
	
	
	?>