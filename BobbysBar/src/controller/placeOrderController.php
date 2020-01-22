<?php
include_once '../model/DBContext.php';
include_once '../model/Customer.php';
include_once '../model/Order.php';
include_once '../model/ItemInBasket.php';
include_once '../model/basketView.php';
session_start();
$errors = array();

/*
 * When an order is placed, the controller first checks whether or not a user with the same details already exists.
 * The controller calls the checkCustomer db function. If a customer is returned then a customer with the same details
 * already exists. The other is then placed with their existing customer ID.
 * If a customer is not returned, then a customer is created, their customer id is returned, and then their order is
 * inserted with the new customer id.
 */

if(isset($_POST['placeOrder'])){
    //collect customer data
    $first_name = trimInputs($_POST['first_name']);
    $surname = trimInputs($_POST['surname']);
    $email = trimInputs($_POST['email']);

    //validate user inputs
    $errors = validateName($first_name, $errors);
    $errors = validateName($surname, $errors);
    $errors = validateEmail($email, $errors);
    print_r($errors);

    if($errors == null){
        //collect order data
        $table_number = $_POST['table_number'];
        date_default_timezone_set("Europe/London");
        $order_time = date("Y-m-d H:i:s");

        //set sessions for order confirmation page
        $_SESSION["cust_email"] = $email;
        $_SESSION["cust_name"] = $first_name . " " . $surname;
        $_SESSION["order_time"] = $order_time;
        $_SESSION["table_number"] = $table_number;

        //check if customer exists
        $db = new DBContext();
        $result = $db->checkCustomer($email);

        //if an array with 1 element is returned from the checkCustomer procedure, a customer has been found.
        if($result){
            $customer_id = implode($result);
            $db->insertOrder($customer_id, $table_number, $order_time);
            //getOrderId for orderdetails table
            $order_id = $db->getLastOrderId();
            //insert basket items to order details table
            $totalCost = 0;
            foreach ($_SESSION['basket'] as $item){
                $product_id = $item->getProductId();
                $itemCost = $item->getCost();
                //quantity will be fixed later
                $quantity = 1;
                $db->insertOrderDetail($order_id, $product_id, $quantity);
            }
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
            $totalCost = 0;
            foreach ($_SESSION['basket'] as $item){
                $product_id = $item->getProductId();
                $itemCost = $item->getCost();
                //quantity will be fixed later
                $quantity = 1;
                $db->insertOrderDetail($order_id, $product_id, $quantity);
            }
        }
        header("Location: ../../public/orderConfirm.php");
    }
}

function trimInputs($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function validateName($name, $errors){
    if(empty($name)){
        array_push($errors, "*Please enter both your first name and surname.");
    }else{
        if(strlen($name) > 29){
            array_push($errors, "Name too long");
        }
        if(!ctype_alpha($name)) {
            array_push($errors, "*Please enter a valid name.");
        }
    }
    return $errors;
}

function validateEmail($email, $errors){
    if(empty($email)){
        array_push($errors, "*Please enter a valid email address.");
    }else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "*Invalid email");
        }
    }
    return $errors;
}

?>