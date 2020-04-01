<?php 

namespace App;

use App\Support\DatabaseConnection;
use Exception;
use App\Support\Builder\QueryFactory;


abstract class Model 
{		
	protected $table;

	protected $parameters;

	protected $parameterData;

	protected $primaryKey = 'id';

	protected $data;

	protected $factory;

    /**
     * Sends data to builder to return query
     * 
     * 
     * @return Array
     */
	public function query() 
	{	
		$data = $this->factory->make('select')->builder(
			$this->parameters, 
			$this->parameterData, 
			$this->query,
			false
		);

		return $data;	
	}

    /**
     * Sends parameter Insertbuilder 
     * 
     * 
     * @return Array
     */
	public function insertQuery()
	{
		$data = $this->factory->make('execute')->builder(
			$this->parameters, 
			$this->parameterData, 
			$this->query,
			false
		);

		return $data;	
	}

    /**
     * Sends parameter Insertbuilder to expect id return
     * 
     * 
     * @return Array
     */
	public function insertQueryTransactions()
	{
		$data = $this->factory->make('execute')->builder(
			$this->parameters, 
			$this->parameterData, 
			$this->query,
			true
		);

		return $data;	
	}

    /**
     * Sends parameter deleteQuery to return query
     * 
     * 
     * @return Array
     */
	public function deleteQuery()
	{
		$data = $this->factory->make('execute')->builder(
			$this->parameters, 
			$this->parameterData, 
			$this->query,
			false
		);

		return $data;
	}

	public function updateQuery()
	{
		$data = $this->factory->make('execute')->builder(
			$this->parameters, 
			$this->parameterData, 
			$this->query,
			false
		);

		return $data;
	}
	
    /**
     * Grabs all data without any filtering
     * 
     * 
     * @return Array
     */
	public function get() 
	{
		return $this->data;
	}

	/**
     * limit data by input limit
     * @param int
     * 
     * @return Array
     */
    public function take($limit) 
    {
        if ($limit < 0) {
            return $this->limit($limit, abs($limit));
        }

        return $this->limit(0, $limit);
    }

    public function limit($offset, $length = null) 
    {	
		return array_slice($this->data, $offset, $length, true);
    }

	/**
     * gets table name
     * 
     * 
     * @return string
     */
	public function getTableName() : string 
	{
		return $this->table;
	}
	
	/**
     * checks if value $this->data exists or not
     * 
     * 
     * @return bool
     */	
	public function exist() : bool
	{
		if (empty($this->data)) {
			return false;
		}
		return true;
	}

	public function updateQueryStringHelper(Array $data) : string 
	{
		if (empty($data)) {
			throw Exception('empty');
		}

		if (count($data) === 1) {
			return $data[0] . '=?'; 
		}

		$lastValue = count($data) - 1;
		$dataString = '';
		foreach ($data as $key => $value) {
			// first
			if ($key === 0) {
				$dataString .= $value . '=?, ';
			}
			// middle			
			if ($key != 0 && $key !== $lastValue) {				
				$dataString .= $value . '=?, ';
			}
			// last
			if ($key === $lastValue) {
				$dataString .= $value . '=?';
			}
		}

		return $dataString;
	}
}
