<?php 

namespace App\Support\Builder;

use App\Support\DatabaseConnection;
use App\Support\Builder\QueryBuilderInterface;

class ExecuteQueryBuilder implements QueryBuilderInterface
{		
	protected $query;

	protected $model;

    public function __construct(\mysqli $con)
    {
        $this->con = $con;        
    }


    /**
    * Query DB using parameter and query string 
    * TODO: Check the affected Rows to see if code has really excuted
    * @return Array
    */  
    public function builder(string $parameter, array $parameterData, string $query) 
    {   
        // Need to throw class exception for this particular error
        if (!$this->validInput($parameter, $parameterData)) {
            throw new Exception('Check Data inputs also if data matches each other for MYSQLI');
        }

        $stmt = $this->con->prepare($query);
        $stmt->bind_param($parameter, ...$parameterData);
        $stmt->execute();
        $stmt->close();

        return true;
    }

    /**
    * Check input types 
    *
    * @return bool
    */  
    public function validInput (string $parameter, Array $parameterData) : bool
    { 
        if (!$parameter || !$parameterData || count($parameterData) != strlen($parameter)) {
            return false;
        }
        return true;
    }
}