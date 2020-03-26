<?php 

namespace App\Transactions;

use App\Model;
use App\Support\Database;

class Transactions extends Model // TODO: STILL NEEDS TO BE WORKED ON
{	
	protected $table = 'transactions';

	public function getTableName() : string 
	{
		return $this->table;
	}

	public function getOrderTransaction($id) 
	{
		$sql ="
		SELECT 
			products.name AS Productname,
			order_trans.price AS Price,
			order_trans.currency AS Currency,
			order_trans.status AS Status 
			FROM products,order_trans 
			WHERE order_trans.userid='$id'
		";
		
	}
/*
	public function getOrderTransaction($id)
	{
		$sql ="
		SELECT 
			products.productname AS Productname,
			order_trans.price AS Price,
			order_trans.currency AS Currency,
			order_trans.status AS Status 
			FROM products,order_trans 
			WHERE order_trans.userid='$id'
		";

		$query = $this->conn->query($sql);
		
		while ($r = mysqli_fetch_assoc($query))
		{
				$rows[]=$r;
		}

		print json_encode($rows);
	}

	public function addOrderTransaction(
		float $price,
		string $currency,
		$productid,
		$userid
	)
	{			
		$validation 	= new validation();	
		$pricevali 		= $validation->pricevalidation($price);	
		$currentvali    = $validation->currentvalidation($currency);	
			
		$sql ="
		INSERT 
			INTO order_trans (price, currency, status, date, productid, userid)
			VALUES 
			($pricevali, '$currentvali', 'Pending', now(), $productid, $userid)
		";
	
		$query = $this->conn->query($sql);

		if ($this->conn->query($sql)) {
			echo "Succesfully added product <br>";
		}

		throw "Failed added product";

	}

	public function updateOrderTransaction(
		$price,
		$currency,
		$status,
		$userid,
		$orderid
	)
	{
		$sql ="
		UPDATE 
			order_trans SET price = '$price', currency= '$currency', status = '$status' 
			WHERE userid = '$userid' and id ='$orderid'
		";

		if ($this->conn->query($sql)) {
			echo "Succesfully Updated order <br>";
		}

		throw "Failed Update order";			
	}

	public function deleteOrderTransaction($userid,$orderid)
	{
		$sql ="DELETE FROM order_trans WHERE userid = '$userid' and id ='$orderid'";
		
		if ($this->conn->query($sql)) {
			echo "Succesfully DELETED order <br>";
		}
		
		throw "Failed Delete order";
	}*/
}
