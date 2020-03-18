<?php

namespace App\Validation;

interface ValidationInterface
{
	public function isValid(bool $strict, $input) : bool;
}