<?php 

require_once __DIR__ . '/vendor/autoload.php';

use App\Customers\Customer;
use App\Customers\OrderItems;
use App\Products\ProductOrder;
use App\Products\Products;
use App\Support\DatabaseConnection;
use App\Transactions\Transactions;
use App\Validation\Customer as CustomerValidation;
use App\Validation\Price;
use App\Support\Builder\QueryFactory;
use Symfony\Component\HttpFoundation\Request;




$data['customer']['customerID'] = 1;
$data['products']['productsID'] = [1,2,3,4,5,6,7];
$data['products']['totalItems'] = [7,1,2,3,4,5,6];

//$run_function = new Transactions();
//$run_function->addTransaction($data);

//$run_function = new QueryFactory();
//$value = $run_function->make('execute');



