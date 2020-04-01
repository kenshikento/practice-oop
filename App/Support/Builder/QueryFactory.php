<?php

namespace App\Support\Builder;

use App\Support\Builder\ExecuteQueryBuilder;
use App\Support\Builder\SelectQueryBuilder;

class QueryFactory
{
	private static $instance;

	public static function getInstance() : self
	{
		if (empty(self::$instance)) {
			 self::$instance = new self();
		}

		return self::$instance;
	}

	public function make(string $queryType)
	{
        switch ($queryType) {
            case 'execute':
                return new ExecuteQueryBuilder();
            case 'select':
                return new SelectQueryBuilder();
        }

        throw new Exception("Unsupported query type [{$queryType}]");		
	}
}