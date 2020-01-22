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
echo "<p>Total Cost: " . $_SESSION["order_TotalCost"] . "</p>";

//Create a table displaying all items ordered.
$tableString = '<table border="1">';
$tableString .= '<tr>';
$tableString .= '<th> Your Order:</th>';
$tableString .= '</tr>';
echo $tableString;
echo '<td>'. "Item" . '</td>';
echo '<td>'. "Cost" . '</td>';

//Display all items in basket that were just purchased.
foreach ($_SESSION['basket'] as $item){
    $product_id = $item->getProductId();
    $product_name = $item->getProductName();
    $category = $item->getCategory();
    $cost = $item->getCost();

    echo '<tr>';
    echo '<td>'. $product_name . '</td>';
    echo '<td>'. "£" . $cost . '</td>';
    echo '</tr>';
}
echo '</table>';

//Destroy session variables
session_destroy();
?>
</html>
