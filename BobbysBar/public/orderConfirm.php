<!DOCTYPE html>
<html>
<?php include 'header.php';
include_once '../src/model/basketView.php';
include_once '../src/model/DBContext.php';

/*
 * This page is displayed after a user places their order to display a confirmation and tell them their order number.
 * This order number is required for them to check their order or cancel their order.
 */

//get last order id
    $db = new DBContext();
    $order_id = $db->getLastOrderId($_SESSION["order_time"]);
    $order_id = implode($order_id);
//Display general order overview.
echo "<div class=order-details>";
echo "<h3>Order Confirmed</h3>";
echo "<p>Order ID: " . $order_id . "</p>";
echo "<p>Customer Name: " . $_SESSION["cust_name"] . "</p>";
echo "<p>Customer Email: " . $_SESSION["cust_email"] . "</p>";
echo "<p>Order Time: " . $_SESSION["order_time"] . "</p>";
echo "<p>Table Number: " . $_SESSION["table_number"] . "</p>";
echo "</div>";

//Destroy session variables
session_destroy();
include_once '../public/footer.php';
?>
</html>
