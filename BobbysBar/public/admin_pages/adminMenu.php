<!DOCTYPE html>
<html>
<?php include '../../public/admin_pages/adminHeader.php';
include_once '../../src/model/DBContext.php';
include_once '../../src/model/MenuDrink_View.php';
include_once '../../src/model/MenuSnack_View.php';
include_once '../../src/model/ItemInBasket.php';
include_once '../../src/model/basketView.php';

/*
 * This page is used to display the current menu to the admin. It displays a lot more information than the public
 * menu as this includes data such as product supplier and sale_status. The sale status is used to determine whether a product
 * is on sale to the public or not. If a sale_status is set as OFFSALE, it does not appear on the public menu as the view
 * will not return it, however it still appears in the admin menu. A button is provided to change an items state.
 * A button is also provided to edit the details of a particular item.
 */

//calling adminMenuDrink_View to get an arraylist returned of all drinks on the menu.
$db = new DBContext();
$drinkResults = $db->adminMenuDrink_View();

//A table is created with the data returned
if ($drinkResults) {
    $tableString = '<table border="1px solid black">';
    $tableString .= '<tr>';
    $tableString .= '<th colspan="7">Drinks</th>';
    $tableString .= '</tr>';
    echo "<div class='admin-table-container'>";
    echo $tableString;

    //column headers
    echo '<tr>';
    echo '<td><b>Snack</b></td>';
    echo '<td><b>Category</b></td>';
    echo '<td><b>Percentage</b></td>';
    echo '<td><b>Price</b></td>';
    echo '<td><b>Status</b></td>';
    echo '<td><b>Edit Item</b></td>';
    echo '<td><b>Change Status</b></td>';
    echo '</tr>';

    //foreach item in retuned array list, get product info and display it in a table.
    foreach ($drinkResults as $result) {
        $product_id = $result->getProductId();
        $product_name = $result->getProductName();
        $category = $result->getCategory();
        $percentage = $result->getPercentage();
        $cost = $result->getCost();
        $sale_status = $result->getSaleStatus();

        echo '<tr>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . $category . '</td>';
        echo '<td>' . $percentage . "%" . '</td>';
        echo '<td>' . "£" . $cost . '</td>';
        echo '<td>' . $sale_status . '</td>';
        echo '<td>';
        //a button is used to pass a particular product id for the item to the edit item view.
        echo '<form action="../admin_pages/adminEditItem.php" method="post">';
        echo '<button type="submit" name="edit_item" value="' . $product_id . '">Edit Item</button>';
        echo '</form>';
        echo '</td>';
        echo '<td>';
        //a button is used to pass a particular product id for the item to the edit item controller. This will change the sale state.
        echo '<form action="../../src/controller/adminEditItemController.php" method="post">';
        echo '<button type="submit" name="change_status" value="' . $product_id . '">On/Off Sale</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
}

echo "<br>";
//repeat the same process, however the table is different for a snack view. Percentage is not required.
$snackResults = $db->adminMenuSnack_View();

//create a table for the data returned from the function called.
if ($snackResults) {
    $tableString = '<table border="1px solid black">';
    $tableString .= '<tr>';
    $tableString .= '<th colspan="6"> Bar Snacks</th>';
    $tableString .= '</tr>';
    echo "<div class='admin-table-container'>";
    echo $tableString;

    //column headers
    echo '<tr>';
    echo '<td><b>Snack</b></td>';
    echo '<td><b>Category</b></td>';
    echo '<td><b>Price</b></td>';
    echo '<td><b>Status</b></td>';
    echo '<td><b>Edit Item</b></td>';
    echo '<td><b>Change Status</b></td>';
    echo '</tr>';

    //create a row for each object returned in the array list
    foreach ($snackResults as $result) {
        $product_id = $result->getProductId();
        $product_name = $result->getProductName();
        $category = $result->getCategory();
        $cost = $result->getCost();
        $sale_status = $result->getSaleStatus();

        echo '<tr>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . $category . '</td>';
        echo '<td>' . "£" . $cost . '</td>';
        echo '<td>' . $sale_status . '</td>';
        echo '<td>';
        //button to input product id for a particular product to the edit item view
        echo '<form action="../admin_pages/adminEditItem.php" method="post">';
        echo '<button type="submit" name="edit_item" value="' . $product_id . '">Edit Item</button>';
        echo '</form>';
        echo '</td>';
        echo '<td>';
        //button to input product id for a particular item to the edit item controller. This will change the sale state.
        echo '<form action="../../src/controller/adminEditItemController.php" method="post">';
        echo '<button type="submit" name="change_status" value="' . $product_id . '">On/Off Sale</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
}
include_once '../admin_pages/adminFooter.php';
?>