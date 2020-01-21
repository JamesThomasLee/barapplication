<!DOCTYPE html>
<html>
<?php include '../../public/admin_pages/adminHeader.php';
include_once '../../src/model/DBContext.php';


if(isset($_POST['view_order'])){
    $order_id = $_POST['view_order'];

    //call db function to collect order details
    $db = new DBContext();
    $results = $db->order_Retrieve($order_id);

    $tablenum = $results->getTableNumber();
    $results = "";
    $results = $db->orderDetails_Retrieve($order_id);

    //get total cost
    $totalcost = 0;
    foreach($results as $result){
        $cost = $result->getCost();
        $quantity = $result->getQuantity();
        //total cost calculation
        $totalcost = $totalcost + ($cost * $quantity);
    }
    echo "<b>Order ID: </b>" . $order_id . "<br>";
    echo "<b>Table Number: </b>" . $tablenum . "<br>";
    echo "<b>Total Cost: </b>" . "£" . $totalcost . "<br>";

    $tableString = '<table border="1">';
    $tableString .= '<tr>';
    $tableString .= '<th> Item </th>';
    $tableString .= '<th> Cost </th>';
    $tableString .= '<th> Quantity </th>';
    $tableString .= '</tr>';
    echo $tableString;

    foreach($results as $result){
        $product_name = $result->getProduct_Name();
        $cost = $result->getCost();
        $quantity = $result->getQuantity();

        echo '<tr>';
        echo '<td>'. $product_name . '</td>';
        echo '<td>'. '£' . $cost . '</td>';
        echo '<td>'. $quantity . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    echo '<button onclick="history.back()">Go Back</button>';

}