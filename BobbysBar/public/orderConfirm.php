<!DOCTYPE html>
<html>
<?php include 'header.php';
include_once '../src/model/basketView.php';

/*
 * This page is displayed after a user places their order to display a confirmation and tell them their order number.
 * This order number is required for them to check their order or cancel their order.
 */

//Display general order overview.
echo "<h1>Order Confirmed</h1>";
echo "<p>Customer Name: " . $_SESSION["cust_name"] . "</p>";
echo "<p>Customer Email: " . $_SESSION["cust_email"] . "</p>";
echo "<p>Order Time: " . $_SESSION["order_time"] . "</p>";
echo "<p>Table Number: " . $_SESSION["table_number"] . "</p>";

//Destroy session variables
session_destroy();
?>
</html>
