<?php 

namespace App\Products;

use App\Model;

class Products extends Model 
{		
	protected $table = 'products';

    /**
     * Gets the Products info by ID.
     *
     * @return $this
     */
	public function findProductsByName()
	{
		$this->query = 'SELECT * FROM ' . $this->table . ' WHERE name=?';
		$this->parameters = 's';
		$this->parameterData = ['Apples'];

		$this->data = $this->insertQuery();

		return $this;
	}

	/**
     * Gets the Customer Info and sets it within current Parameter By Email.
     *
     * @return $this
     */
	public function findCustomerByName(string $id)
	{
		$this->query = 'SELECT * FROM ' . $this->table . ' WHERE id=?';
		$this->parameters = 'i';
		$this->parameterData = [$id];

		$this->data = $this->query();

		return $this;
	}
}
