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
		public function getorder_trans($id)
		{
			$sql ="SELECT products.productname AS Productname, order_trans.price AS Price, order_trans.currency AS Currency,order_trans.status AS Status FROM products,order_trans WHERE order_trans.userid='$id'";
	
			$query = $this->conn->query($sql);
			
			while ($r = mysqli_fetch_assoc($query))
				{
					$rows[]=$r;
				}
			print json_encode($rows);
		}
		public function addorder_trans($price,$currency,$productid,$userid)
		{			
	
				$validation = new validation();	
				$pricevali=$validation->pricevalidation($price);	
				$currentvali=$validation->currentvalidation($currency);	
					
				$sql ="INSERT INTO order_trans (price,currency,status,date,productid,userid)VALUES ($pricevali,'$currentvali','Pending',now(),$productid,$userid)";
			
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
		public function updateorder_trans($price,$currency,$status,$userid,$orderid)
		{
			$sql ="UPDATE order_trans SET price = '$price', currency= '$currency', status = '$status' WHERE userid = '$userid' and id ='$orderid'";
				if($this->conn->query($sql))
					{
							echo "Succesfully Updated order <br>";
					}
					else
					{
							echo "Failed Update order";
					}
			
		}
		public function deleteorder_trans($userid,$orderid)
		{
				$sql ="DELETE FROM order_trans WHERE userid = '$userid' and id ='$orderid'";
			
				if($this->conn->query($sql))
					{
							echo "Succesfully DELETED order <br>";
					}
					else
					{
							echo "Failed Delete order";
					}
		}
		
		
		
	}


	$run_function = new payments();
	//check User
	//$run_function ->checkCustomer('kenshikento','pwd');
	//show order_trans
	//$run_function->getorder_trans(1);
	// addorder_trans
	//$run_function->addorder_trans(100,'KRW','1','1');
	//updateorder_trans
	//$run_function->updateorder_trans('200','KRW','Accepted','1','1');
	//DELETE trasnaction
	//$run_function->deleteorder_trans(1,3);
	//Test validation
	//$run_function->testValidation(1,'AAA','1','1');
	
	
	?>