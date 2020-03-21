<?php 

namespace App\Products;

use App\Model;
use App\Validation\Products as ProductsValidation;
use Symfony\Component\HttpFoundation\Request;

class Products extends Model 
{		
	protected $table = 'products';

    /**
     * Gets the Products info by ID.
     *
     * @return $this
     */
	public function findProductsByName(string $name)
	{
		$this->query = 'SELECT * FROM ' . $this->table . ' WHERE Name=?';
		$this->parameters = 's';
		$this->parameterData = [$name];

		$this->data = $this->query();

		return $this;
	}

	/**
     * Gets the Customer Info and sets it within current Parameter By id.
     *
     * @return $this
     */
	public function findProductsById(string $id)
	{
		$this->query = 'SELECT * FROM ' . $this->table . ' WHERE id=?';
		$this->parameters = 'i';
		$this->parameterData = [$id];

		$this->data = $this->query();

		return $this;
	}

    /**
     * deletes product by id.
     *
     * @return bool
     */
	public function deleteProducts(int $id, string $name) : bool
	{
		$this->query = 'DELETE FROM '. $this->table . ' WHERE id=? AND name=?';
		$this->parameters = 'is';
		$this->parameterData = [$id, $name];

		if ($this->deleteQuery()) {
			return true;
		}

		return false;
	}
    /**
     * Insert Customer.
     *
     * @return bool
     */
	public function addProducts(Request $request) : bool
	{
		$validation = new ProductsValidation();
		
		// Need to t hink of way to send error back
		if (!$validation->isValid(true, $request)) {
			//return $validation->errors;
			return false;
		}

		// Need to find better way to get request data 
		$name = $request->request->get('name');
		$price = $request->request->get('price'); 

		$this->query = 'INSERT INTO '. $this->table . '(Name, Price) VALUES (?, ?)';
		$this->parameters = 'si';
		$this->parameterData = [$name, $price];

		if ($this->insertQuery()) {
			return true;
		}

		return false;
	}

    /**
     * Updates Product table value 
     *
     * @return bool
     */
	public function updateProducts(Request $request) : bool 
	{
		$validation = new ProductsValidation();

		if (!$validation->isValid(false, $request)) {
			//return $validation->errors;
			return false;
		}

		$id = $request->request->get('id');
		$name = $request->request->get('name');
		$price = $request->request->get('price');

		$data = [];

		$this->parameters = 'sss';
		$this->parameterData = [$price, $id, $name];
		$this->query = 'UPDATE ' . $this->table . ' SET Price=?  WHERE id=? AND name=?';

		if ($this->updateQuery()) {
			return true;
		}

		return false;		
	}


}

