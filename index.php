<?php 

require_once __DIR__ . '/vendor/autoload.php';

use App\Support\DatabaseConnection;
use App\Validation\Price;
use App\Customers\Customer;
use App\Products\Products;
use Test\Concerns\SeedSites;
use Symfony\Component\HttpFoundation\Request;

//$run_function = new Products();
//$result = $run_function->findProductsByName('Apples')->get();
//$request = Request::createFromGlobals();
//dd($request);

$run_function = new Customer();
$result = $run_function->deleteCustomer(2);