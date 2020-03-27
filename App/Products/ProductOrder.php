<?php 

namespace App\Products;

use App\Model;

class ProductOrder extends Model 
{		
	protected $table = 'producttransaction';

	public function add(Array $data) 
	{
		$productID = $data['productsID'];
		$quantity = $data['totalItems'];

		$this->query = 'INSERT INTO '. $this->table . ' (ProductID, Quantity) VALUES (?, ?)';

		$this->parameters = 'ii';
		$this->parameterData = [$productID, $quantity];

		$returnValue = $this->insertQueryTransactions();
		
		if ($returnValue) {
			return $returnValue;
		}

		return false;
	}
}
