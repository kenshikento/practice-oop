<?php 

namespace App\Customers;

use App\Model;
use \Carbon\Carbon;

class OrderItems extends Model 
{		
	protected $table = 'orderitems';

	public function add(Array $data)
	{
		if (!array_key_exists('customerID', $data)) {
			throw new Exception('Not all data has been sent');
		}

		if (!$data['customerID']) {
			throw new Exception('customerID is missing');
		}

		$customerID = $data['customerID'];
		
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
