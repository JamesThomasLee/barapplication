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
        $orderID = $_POST['order_id'];

        $db = new DBContext();
        $results = $db->order_Retrieve($orderID);

        if($results){
            $id = $results->getOrderId();
            $tablenum = $results->getTableNumber();
            echo "<b>Order ID: </b>" . $id . "<br>";
            echo "<b>Table Number: </b>" . $tablenum . "<br>";

            $results = "";
            $results = $db->orderDetails_Retrieve($orderID);

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
                echo '<td>'. $cost . '</td>';
                echo '<td>'. $quantity . '</td>';
                echo '</tr>';
            }
            echo '</table>';

        }else{
            echo "Order not found.";
        }
    }
    ?>
</p>
</body>

<?php include 'footer.php';?>