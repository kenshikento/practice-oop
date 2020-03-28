<?php 

namespace App\Transactions;

use App\Customers\OrderItems;
use App\Model;
use App\Products\ProductOrder;
use App\Validation\Transactions as TransactionsValidation;
use App\Support\Database;

class Transactions extends Model // TODO: STILL NEEDS TO BE WORKED ON
{	
	protected $table = 'transactions';

	public function getTableName() : string 
	{
		return $this->table;
	}

    /**
     * Gets Transaction info by ID.
     *
     * @return $this
     */
	public function getOrderTransactionByCustomerID($id) 
	{
		$this->query ="
		SELECT 
			a.Date AS OrderDate,
			a.ID AS OrderID,
			b.ID AS TransactionID,
			c.Quantity AS Quantity,
			d.Name AS ProductName
			FROM orderitems a 
			join transactions b on b.OrderItemsID = a.ID 
			left join producttransaction c on c.ID = b.ProductsTransactionID
			join products d on d.ID = c.ProductID 
			WHERE a.CustomerID = ?
		";

		$this->parameters = 'i';
		$this->parameterData = [$id];

		$this->data = $this->query();

		return $this;
	}

    /**
     * Adds transaction using addOrderitems && add Productorders
     *
     * @return bool
     */
	public function addTransaction(Array $data)
	{			
		$validation = new TransactionsValidation();

		if (!$validation->isValid(true, $data)) {
			return false;
		}

		$customerID = $data['customer']['customerID'];
		


		$orderID = $this->addOrderItems($customerID);
		$product 	= $this->addProductOrders($data['products']);

		foreach ($product as $value) {
			$this->query ="
			INSERT 
				INTO ". $this->table ." (ProductsTransactionID, OrderItemsID)
				VALUES 
				(?, ?)
			";

			$this->parameters = 'ii';
			$this->parameterData = [$value, $orderID];

			if ($this->insertQuery()) {
				return true;
			}			

			throw new Exception('transaction did not work');
		}

	}

    /**
     * Adds addOrderitems 
     *
     * @return int
     */
	public function addOrderItems($customerID) : int
	{
		$orderItems = new OrderItems();
		$orderID = $orderItems->add(['customerID' => $customerID]);
		return $orderID;
	}
	
	/**
     * Adds addProductOrders 
     *
     * @return array
     */
	public function addProductOrders(Array $data) : array
	{
		$products = [];
		$productID = [];
		$productOrders = new ProductOrder();

		foreach ($data['productsID'] as $key => $product) {

			$products['productsID']  = $data['productsID'][$key];
			$products['totalItems'] =  $data['totalItems'][$key];

			$productID[] = $productOrders->add($products);
		}

		return $productID;
	}
}


    // TODO : UPDATE / DELETE
	/* OLD CODE
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