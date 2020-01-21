<!DOCTYPE html>
<html>
<?php include 'header.php';
include_once('../src/model/DBContext.php');
include_once '../src/model/orderView_Customer.php';
include_once '../src/model/orderDetailView_Customer.php';
?>

<body>
<p>
    <?php
    include_once('../src/view/orderLookUp.php');


    if(isset($_POST['orderLookUp'])){
        //collect orderID from text box
        $orderID = $_POST['order_id'];

        //set session ID for cancel order function
        $_SESSION["order_id"] = $orderID;

        //call db function to collect order details
        $db = new DBContext();
        $results = $db->order_Retrieve($orderID);

        if($results){
            $id = $results->getOrderId();
            $tablenum = $results->getTableNumber();
            $results = "";
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

            //button for a user to cancel their order - calls deleteOrder controller
            echo "<form action='../src/controller/deleteOrder.php' method='post'>";
            echo "<button type='submit' name='deleteOrder'>Cancel Order</button>";
            echo "</form>";

        }else{
            echo "Order not found.";
        }
    }
    ?>
</p>
</body>

<?php include 'footer.php';?>