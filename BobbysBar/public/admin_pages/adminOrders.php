<!DOCTYPE html>
<html>
<?php include '../../public/admin_pages/adminHeader.php';
include_once '../../src/model/orderView_Admin.php';
include_once '../../src/model/DBContext.php';

/*
 * This page displays a table of all of the orders placed. The administrator can click the view order button
 * next to a particular order to view the contents of that order.
 */

//call db function to collect order details
$db = new DBContext();
$results = $db->adminOrders();

//Create a table of all of the orders returned.
if($results){
    $tableString = '<table border="1">';
    $tableString .= '<tr>';
    $tableString .= '<th colspan="5">Orders</th>';
    $tableString .= '</tr>';
    $tableString .= '<tr>';
    $tableString .= '<td>Order ID</td>';
    $tableString .= '<td>Order Date/Time</td>';
    $tableString .= '<td>Customer ID</td>';
    $tableString .= '<td>Table Number</td>';
    $tableString .= '<td>View Order</td>';
    $tableString .= '</tr>';
    echo "<div class=admin-table-container>";
    echo $tableString;

    //for each order in the array list returned create a new table row.
    foreach($results as $result){
        $order_id = $result->getOrderId();
        $date_time = $result->getDateTime();
        $customer_id = $result->getCustomerId();
        $table_number = $result->getTableNumber();

        echo '<tr>';
        echo '<td>'. $order_id . '</td>';
        echo '<td>'. $date_time . '</td>';
        echo '<td>'. $customer_id . '</td>';
        echo '<td>'. $table_number . '</td>';
        echo '<td>';
        //a button to view the order in more detail
        echo '<form action="../../public/admin_pages/adminViewOrder.php" method="post">';
        echo '<button type="submit" name="view_order" value="' . $order_id . '">View Order</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo "</div>";
}else{
    echo "<div class=no-items>";
    echo "<p>No orders.</p>";
    echo "</div>";
}

include_once '../admin_pages/adminFooter.php';
?>
