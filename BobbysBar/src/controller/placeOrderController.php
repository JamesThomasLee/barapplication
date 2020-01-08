<?php

if(isset($_POST['placeOrder'])){
//collect customer data
$first_name = $_POST['first_name'];
$surname = $_POST['surname'];
$email = $_POST['email'];

//collect order data
$table_number = $_POST['table_number'];
$order_time = date("Y-m-d H:i:s");

echo $first_name . '<br>';
echo $surname . '<br>';
echo $email . '<br>';
echo $table_number . '<br>';
echo $order_time . '<br>';

}

?>