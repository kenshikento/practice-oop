<?php 

namespace App\Customers;

use App\Model;
use App\Support\Builder\QueryFactory;
use App\Support\DatabaseConnection;
use App\Validation\Customer as CustomerValidation;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class Customer extends Model 
{		
	protected $table = 'customer';

	public function __construct() 
	{
		$this->validation = new CustomerValidation();
		$this->factory = QueryFactory::getInstance();
	}

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
	public function addCustomer(Array $data) 
	{	
		$validation = new CustomerValidation();
		
		// Need to think of way to send error back
		if (!$validation->isValid(true, $data)) {
			//return $validation->getErrors();
			return false;
		}

		// Need to find better way to get request data 
		$name = $data['name'];
		$age = $data['age'];
		$email = $data['email']; 

		$this->query = 'INSERT INTO '. $this->table . '(Name, Age, Email) VALUES (?, ?, ?)';
		$this->parameters = 'sss';
		$this->parameterData = [$name, $age, $email];

		if ($this->insertQuery()) {
			return true;
		}

		return false;
	}

    /**
     * deletes customer by id.
     *
     * @return bool
     */
	public function deleteCustomer(int $id) : bool
	{
		$this->query = 'DELETE FROM '. $this->table . ' WHERE id=?';
		$this->parameters = 'i';
		$this->parameterData = [$id];

		if ($this->deleteQuery()) {
			return true;
		}

		return false;
	}

    /**
     * updates customer 
     *
     * @return bool
     */
	public function updateCustomer(Array $data)
	{	
		$validation = new CustomerValidation();

		if (!$validation->isValid(false, $data)) {
			//return $validation->errors;
			return false;
		}

		$email = $data['email'];
		$name = $data['name'];
		$age = $data['age'];

		$data = [];

		if ($name) {
			$parameterNames[] = 'name';
			$this->parameterData[] = $name;
			$this->parameters .= 's';
		} 

		if ($age) {
			$parameterNames[] = 'age';
			$this->parameterData[] = $age;
			$this->parameters .= 's';
		}

		$this->parameters .= 's';
		$this->parameterData[] = $email;

		if(empty($parameterNames) || count($parameterNames) + 1  != strlen($this->parameters)) {
			//Need to figure out way throw error out without shutting down system
			//throw new Exception('updating nothing');
			return false;
		}

		$paramz = $this->updateQueryStringHelper($parameterNames);	

		$this->query = 'UPDATE ' . $this->table . ' SET '. $paramz .' WHERE email=?';
		
		if ($this->updateQuery()) {
			return true;
		}

		return false;
	}
}
