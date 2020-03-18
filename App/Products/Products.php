<?php 

namespace App\Products;

use App\Model;

class Products extends Model 
{		
	protected $table = 'products';

    /**
     * Gets the Customer ID.
     *
     * @return Array
     */
	public function findProductsByName($limit = 5)
	{
		$this->query = 'SELECT * FROM ' . $this->table . ' WHERE name=?';
		$this->parameters = 's';
		$this->parameterData = ['Apples'];

		$this->data = $this->insertQuery();

		return $this;
	}
}
