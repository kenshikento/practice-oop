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



//$run_function = new apples();
//$run_function->test();

/*$run_function = new OrderItems();
$name = $run_function->add(['customerID' => 1]);
dd($name);*/


$data['customer']['customerID'] = 1;
$data['products']['productsID'] = [1,2,3,4,5,6,7];
$data['products']['totalItems'] = [7,1,2,3,4,5,6];

$run_function = new Transactions();
$run_function->addTransaction($data);

/*$run_function = new ProductOrder();
$name = $run_function->add(['productID' => 1,'quantity' => 1]);
dd($name);*/

