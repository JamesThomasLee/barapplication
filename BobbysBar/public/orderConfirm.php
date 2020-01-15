<!DOCTYPE html>
<html>
<?php include 'header.php';
include_once '../src/model/basketView.php';

echo "<h1>Order Confirmed</h1>";
echo "<p>Customer Name: " . $_SESSION["cust_name"] . "</p>";
echo "<p>Customer Email: " . $_SESSION["cust_email"] . "</p>";
echo "<p>Order Time: " . $_SESSION["order_time"] . "</p>";
echo "<p>Table Number: " . $_SESSION["table_number"] . "</p>";
echo "<p>Total Cost: " . $_SESSION["order_TotalCost"] . "</p>";

$tableString = '<table border="1">';
$tableString .= '<tr>';
$tableString .= '<th> Your Order:</th>';
$tableString .= '</tr>';
echo $tableString;
echo '<td>'. "Item" . '</td>';
echo '<td>'. "Cost" . '</td>';

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

session_destroy();
?>
</html>
