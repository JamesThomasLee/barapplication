<!DOCTYPE html>
<html>
<?php include 'header.php';
include_once('../src/model/DBContext.php');
include_once '../src/model/orderView_Customer.php';
include_once '../src/model/orderDetailView_Customer.php';
$errors = array();
/*
 * This page is used to allow a user to look up their order. They input their order number. If the order number
 * does not match an order in the database then an error message is displayed. If it does match an order then this order
 * is displayed on this page.
 * The user will have an option to cancel their order on this page.
 */

    //include order look up form.
    include_once('../src/view/orderLookUp.php');

    //if search button is pressed
    if(isset($_POST['orderLookUp'])){
        //collect orderID from text box
        $orderID = trimInputs($_POST['order_id']);

        $errors = validateOrderID($orderID, $errors);

        if($errors == null){
            //set session ID for cancel order function
            $_SESSION["order_id"] = $orderID;

            //call db function to collect order details
            $db = new DBContext();
            $results = $db->order_Retrieve($orderID);

            //if the function finds a matching order
            if($results){
                //clear errors
                $errors = null;
                //display basic order information
                $id = $results->getOrderId();
                $tablenum = $results->getTableNumber();
                $results = "";
                //call a function to get details of items in the order
                $results = $db->orderDetails_Retrieve($orderID);

                //get total cost
                $totalcost = 0;
                foreach($results as $result){
                    $cost = $result->getCost();
                    $quantity = $result->getQuantity();
                    //total cost calculation
                    $totalcost = $totalcost + ($cost * $quantity);
                }
                echo "<b>Order ID: </b>" . $id . "<br>";
                echo "<b>Table Number: </b>" . $tablenum . "<br>";
                echo "<b>Total Cost: </b>" . "£" . $totalcost . "<br>";

                //create a table to display items in order
                $tableString = '<table border="1">';
                $tableString .= '<tr>';
                $tableString .= '<th> Item </th>';
                $tableString .= '<th> Cost </th>';
                $tableString .= '<th> Quantity </th>';
                $tableString .= '</tr>';
                echo $tableString;

                //add a table row for each item in order
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

                //button for a user to cancel their order - calls deleteOrder controller
                echo "<form action='../src/controller/deleteOrder.php' method='post'>";
                echo "<button type='submit' name='deleteOrder'>Cancel Order</button>";
                echo "</form>";

            }else{
                //message displayed if an order is not found
                array_push($errors, "Order not found.");
            }
        }

        printErrors($errors);
    }

    //strip inputs
    function trimInputs($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    //validate input
    function validateOrderID($order_id, $errors){
        if(empty($order_id)){
            array_push($errors, "*Please enter an order number.");
        }else{
            if(is_numeric($order_id)){

            }else{
                array_push($errors, "*Order number invalid.");
            }
        }
        return $errors;
    }

    //print errors
    function printErrors($errors){
    foreach($errors as $error){
        echo $error . "<br>";
    }
}
?>


<?php include 'footer.php';?>