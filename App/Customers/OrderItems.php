<?php 

namespace App\Customers;

use App\Model;
use \Carbon\Carbon;

class OrderItems extends Model 
{		
	protected $table = 'orderitems';

	public function add(Array $data)
	{
		$customerID = $data['customerID'];
		// Need to add validation
		$this->query = 'INSERT INTO '. $this->table . '(CustomerID, Date) VALUES (?, now())';		
		$this->parameters = 'i';
		$this->parameterData = [$customerID];
		$returnValue = $this->insertQueryTransactions();

		if ($returnValue) {
			return $returnValue;
		}

		throw new Exception('failed adding in orderitems');
	}
}
