<?php

namespace Tests\Validation;

use PHPUnit\Framework\TestCase;
use App\Validation\Currency;

class CurrencyTest extends TestCase
{
	public function setUp() : void
	{
		$this->validation = new Currency();
	}

	public function testCurrencyWhiteListAssetsToTrue()
	{
		$this->assertTrue($this->validation->isValid(true, 'KRW', null));
	}

	public function testCurrencyWhiteListAssetsTofalse()
	{
		$this->assertFalse($this->validation->isValid(true, 'Crack', null));
	}
}
