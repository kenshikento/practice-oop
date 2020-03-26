<?php 

require_once __DIR__ . '/vendor/autoload.php';

use App\Support\DatabaseConnection;
use App\Validation\Price;
use App\Customers\Customer;
use App\Validation\Customer as CustomerValidation;
use App\Products\Products;
use Test\Concerns\SeedSites;
use Symfony\Component\HttpFoundation\Request;

//$run_function = new Products();
//$result = $run_function->findProductsByName()->get();
//$run_function = new Customer();
//$result = $run_function->findCustomerByEmail('dherzog@erdman.info')->get();

//$start_Method = new MockTest();
//$result = $start_Method->getRequest();
//dd($result);
//$run_function = new Customer();
//$result = $run_function->deleteCustomer(2);

class apples 
{
	use SeedSites;

	public function test() 
	{
		$this->setUpDb();

	}
}

$run_function = new apples();
$run_function->test();