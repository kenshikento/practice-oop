<?php 

namespace App\Customers;

use App\Model;
use App\Validation\Customer as CustomerValidation;
use Symfony\Component\HttpFoundation\Request;

class Customer extends Model 
{		
	protected $table = 'customer';

    /**
     * Gets the Customer Info and sets it within current Parameter By ID.
     *
     * @return $this
     */
	public function findCustomerByID(int $id)
	{
		$this->query = 'SELECT * FROM ' . $this->table . ' WHERE id=?';
		$this->parameters = 'i';
		$this->parameterData = [$id];

		$this->data = $this->query();

		return $this;
	}

    /**
     * Gets the Customer Info and sets it within current Parameter By Email.
     *
     * @return $this
     */
	public function findCustomerByEmail(string $email)
	{
		$this->query = 'SELECT * FROM ' . $this->table . ' WHERE email=?';
		$this->parameters = 's';
		$this->parameterData = [$email];

		$this->data = $this->query();

		return $this;
	}

    /**
     * Insert Customer.
     *
     * @return bool
     */
	public function addCustomer(Request $request) : bool
	{
		$validation = new CustomerValidation();
		
		// Need to t hink of way to send error back
		if (!$validation->isValid(true, $request)) {
			//return $validation->errors;
			return false;
		}

		// Need to find better way to get request data 
		$name = $request->request->get('name');
		$age = $request->request->get('age');
		$email = $request->request->get('email'); 

		$this->query = 'INSERT INTO '. $this->table . '(Name, Age, Email) VALUES (?, ?, ?)';
		$this->parameters = 'sss';
		$this->parameterData = [$name, $age, $email];

		if ($this->insertQuery()) {
			return true;
		}

		return false;
	}

	public function deleteCustomer(int $id)
	{
		$this->query = 'DELETE FROM '. $this->table . ' WHERE id=?';
		$this->parameters = 'i';
		$this->parameterData = [$id];

		if ($this->deleteQuery()) {
			return true;
		}

		return false;
	}

	public function updateCustomer()
	{
		
	}
}
