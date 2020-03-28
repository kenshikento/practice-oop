<?php 

namespace App\Products;

use App\Model;

class ProductOrder extends Model 
{		
	protected $table = 'producttransaction';

	public function add(Array $data) 
	{
		if (!array_key_exists('productsID', $data) || !array_key_exists('totalItems', $data)) {
			throw new Exception('Not all data has been sent');
		}

		if (!$data['productsID'] || !$data['totalItems']) {
			throw new Exception('product or quantity is missing');
		}

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
