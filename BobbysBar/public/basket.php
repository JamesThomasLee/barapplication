<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="../assets/css/myStylesheet.css">
<html>
<?php
include_once '../src/model/MenuDrink_View.php';
include_once '../src/model/ItemInBasket.php';
include_once '../src/model/basketView.php';
include 'header.php';
?>
<body>
<?php

/*
 * This page displays a table containing all items in a users basket. The basket is a session variable.
 * In the menu all items are serialized. This is to prevent data loss when passing
 * an array list into a session variable. The items are displayed in a table on this page.
 * The items are deserialized when they reach the controller.
 */

if($_SESSION['basket'] != null){
    //create a table to display the items in the basket.
    //the counter is used by the remove item button.
    $counter = -1;
    $tableString = '<table border="1">';
    $tableString .= '<tr>';
    $tableString .= '<th colspan="3"> Your Basket:</th>';
    $tableString .= '</tr>';
    echo "<div class=table-container>";
    echo $tableString;
    echo '<td><b>Item</b></td>';
    echo '<td><b>Cost</b></td>';
    echo '<td><b>Remove Item</b></td>';
    //echo '<td>'. "Quantity" . '</td>';

    //list each item in the session variable in a table
    foreach ($_SESSION['basket'] as $item){
    $product_id = $item->getProductId();
    $product_name = $item->getProductName();
    $category = $item->getCategory();
    $cost = $item->getCost();
    $quantity = 1;
    $counter = $counter + 1;

    $item = new basketView($product_id, $product_name, $category, $cost);
    $serialized = base64_encode(serialize($item));

    echo '<tr>';
    echo '<td>'. $product_name . '</td>';
    echo '<td>'. "£" . $cost . '</td>';
    //I have a drop down box to select quantity however this is currently causing an error so has been removed.
    /*
    echo '<td>'. '<select name = "quantity" id="quantity">';
            //drop down box for quantity (up to 9)
            $i = 1;
            for ($i = 1; $i < 10; $i++) {
            echo '<option value=' . $i . '>' . $i . '</option>';
            }
            echo '</select>';
        */
    echo '<td>';
    echo '<form action="../src/controller/basketController.php" method="post">';
        echo '<button type="submit" name="remove_basket" value="' . $product_id . '">Remove Item</button>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    }
    echo '</table>';
    echo "</div>";
?>

<div class="basket_buttons">
    <form action="../src/controller/basketController.php" method="post">
        <button type="submit" name="addToBasket">Continue Shopping</button>
        <button type="submit" name="clear_basket">Clear Basket</button>
    </form>
</div>


<?php
//place order form
echo "<div class=order-form>";
    include_once('../src/view/placeOrder.php');
echo "</div>";
}else{
    echo "<div class=no-items>";
    echo "<p>No items in basket.</p>";
    echo "</div>";
}
?>
<?php include 'footer.php';?>
