<?php
include_once '../model/DBContext.php';
include_once '../model/Customer.php';
include_once '../model/Order.php';
include_once '../model/ItemInBasket.php';
session_start();

if(isset($_POST['placeOrder'])){
//collect customer data
$first_name = $_POST['first_name'];
$surname = $_POST['surname'];
$email = $_POST['email'];

//collect order data
$table_number = $_POST['table_number'];
date_default_timezone_set("Europe/London");
$order_time = date("Y-m-d H:i:s");

echo $first_name . '<br>';
echo $surname . '<br>';
echo $email . '<br>';
echo $table_number . '<br>';
echo $order_time . '<br>';

//check if customer exists
    $db = new DBContext();
    $result = $db->checkCustomer($email);

    //if an array with 1 element is returned from the checkCustomer procedure, a customer has been found.
    if($result){
        $customer_id = implode($result);
        $db->insertOrder($customer_id, $table_number, $order_time);
    }else{
        //no customer with that email
        //create customer (customer id set as 0 as it is not passed in. It is auto assigned)
        //order object created however not used on sql insertion. Problem with bindParam function.
        $customer = new Customer(0, $first_name, $surname, $email);
        $db->insertCustomer($first_name, $surname, $email);
        $result = $db->checkCustomer($email);
        $customer_id = implode($result);

        //create order
        //order object created however not used on sql insertion. Problem with bindParam function.
        $order = new Order(0, $customer_id, $table_number, $order_time);
        $db->insertOrder($customer_id, $table_number, $order_time);
        //getOrderId for orderdetails table
        $order_id = $db->getLastOrderId();
        //insert basket items to order details table
        //foreach ($_SESSION['basket'] as $item){
          //  $product_id = $item->getProductId();
            //quantity will be fixed later
            //$quantity = 1;
            //$db->insertOrderDetail($order_id, $product_id, $quantity);
       // }
    }
}

?>