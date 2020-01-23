<!DOCTYPE html>
<html>

<?php
include_once('header.php');
include_once('../src/model/DBContext.php');
include_once('../src/model/MenuDrink_View.php');
include_once('../src/model/ItemInBasket.php');
include_once('../src/model/basketView.php');
/*
 * On this page drink view function and snack view functions are called to return array lists of menu items.
 * They are displayed here in two seperate tables with buttons to add the item to their basket.
 * Only items with a sale_status of ONSALE are returned by the views.
 * Each item is serialized to prevent data loss when it is added to the basket (Session variables were causing an error
 * without being serialized and encoded).
 */

?>

<body>
    <?php
    $db = new DBContext();
    //call function to return an array list of drinks
    $drinkResults = $db->MenuDrink_View();

    if($drinkResults){
        //create a table for drinks
        $tableString = '<table border="1px solid black">';
        $tableString .= '<tr>';
        $tableString .= '<th colspan="5"> Drinks</th>';
        $tableString .= '</tr>';
        echo "<div class='table-container'>";
        echo $tableString;

        //column headers
        echo '<tr>';
        echo '<td><b>Drink</b></td>';
        echo '<td><b>Category</b></td>';
        echo '<td><b>Percentage</b></td>';
        echo '<td><b>Price</b></td>';
        echo '<td><b>Add to Basket</b></td>';
        echo '</tr>';

        //for each drink returned in the array list create a row and populate it with data
        foreach ($drinkResults as $result){
            $product_id = $result->getProductId();
            $product_name = $result->getProductName();
            $category = $result->getCategory();
            $percentage = $result->getPercentage();
            $cost = $result->getCost();
            $quantity = 1;

            //this is used to serialize an item so it can be added to the basket session array list. If I did not
            //serialize the item it was losing data.
            $item = new ItemInBasket($product_id, $product_name, $category, $cost, $quantity);
            $serialized = base64_encode(serialize($item));

            echo '<tr>';
            echo '<td>'. $product_name . '</td>';
            echo '<td>'. $category . '</td>';
            echo '<td>'. $percentage . "%" . '</td>';
            echo '<td>'. "£" . $cost . '</td>';
            echo '<td>';
            //button to add an item to the basket. Serialized item is passed to the controller.
            echo '<form action="../src/controller/basketController.php" method="post">';
            echo '<button type="submit" name="add_basket" value="' . $serialized . '">Add to Basket</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo "</div>";
    }

    echo "<br>";
    //call function to return all snacks in menu
    $snackResults = $db->MenuSnack_View();

    //snacks returned as array list
    if($snackResults){
        //create table to display snacks
        $tableString = '<table border="1px solid black">';
        $tableString .= '<tr>';
        $tableString .= '<th colspan="4"> Bar Snacks</th>';
        $tableString .= '</tr>';
        echo "<div class='table-container'>";
        echo $tableString;

        //column headers
        echo '<tr>';
        echo '<td><b>Food</b></td>';
        echo '<td><b>Category</b></td>';
        echo '<td><b>Price</b></td>';
        echo '<td><b>Add to Basket</b></td>';
        echo '</tr>';

        //for each item returned as a snack, create a new table row.
        foreach ($snackResults as $result){
            $product_id = $result->getProductId();
            $product_name = $result->getProductName();
            $category = $result->getCategory();
            $cost = $result->getCost();
            $quantity = 1;

            //this is used to serialize an item so it can be added to the basket session array list. If I did not
            //serialize the item it was losing data.
            $item = new basketView($product_id, $product_name, $category, $cost, $quantity);
            $serialized = base64_encode(serialize($item));

            echo '<tr>';
            echo '<td>'. $product_name . '</td>';
            echo '<td>'. $category . '</td>';
            echo '<td>'. "£" . $cost . '</td>';
            echo '<td id="table-button">';
            //buttom to add item to basket. Serialized item sent to basket controller.
            echo '<form action="../src/controller/basketController.php" method="post">';
            echo '<button type="submit" name="add_basket" value="' . $serialized . '">Add to Basket</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo "</div>";
    }
    ?>

</body>

<?php include 'footer.php';?>