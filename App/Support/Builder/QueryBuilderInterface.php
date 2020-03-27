<?php

namespace App\Support\Builder;

interface QueryBuilderInterface
{
	public function builder(string $parameter, array $parameterData, string $query, ?bool $return);
	public function validInput(string $parameter, array $parameterData) : bool;
}