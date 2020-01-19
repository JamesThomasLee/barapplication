<!DOCTYPE html>
<html>
<?php include '../../public/admin_pages/adminHeader.php';
include_once '../../src/model/DBContext.php';
include_once '../../src/model/MenuDrink_View.php';
include_once '../../src/model/MenuSnack_View.php';
include_once '../../src/model/ItemInBasket.php';
include_once '../../src/model/basketView.php';

$db = new DBContext();
$drinkResults = $db->MenuDrink_View();

if ($drinkResults) {
    $tableString = '<table border="1px solid black">';
    $tableString .= '<tr>';
    $tableString .= '<th> Drinks</th>';
    $tableString .= '</tr>';
    echo $tableString;

    foreach ($drinkResults as $result) {
        $product_id = $result->getProductId();
        $product_name = $result->getProductName();
        $category = $result->getCategory();
        $percentage = $result->getPercentage();
        $cost = $result->getCost();
        $quantity = 1;

        $item = new ItemInBasket($product_id, $product_name, $category, $cost, $quantity);
        $serialized = base64_encode(serialize($item));

        echo '<tr>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . $category . '</td>';
        echo '<td>' . $percentage . "%" . '</td>';
        echo '<td>' . "£" . $cost . '</td>';
        echo '<td>';
        echo '<form action="../../src/view/editItem.php" method="post">';
        echo '<button type="submit" name="edit_item" value="' . $product_id . '">Edit Item</button>';
        echo '</form>';
        echo '</td>';
        echo '<td>';
        echo '<form action="../src/controller/basketController.php" method="post">';
        echo '<button type="submit" name="change_status" value="' . $product_id . '">On/Off Sale</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

echo "<br>";
$snackResults = $db->MenuSnack_View();

if ($snackResults) {
    $tableString = '<table border="1px solid black">';
    $tableString .= '<tr>';
    $tableString .= '<th> Bar Snacks</th>';
    $tableString .= '</tr>';
    echo $tableString;

    foreach ($snackResults as $result) {
        $product_id = $result->getProductId();
        $product_name = $result->getProductName();
        $category = $result->getCategory();
        $cost = $result->getCost();
        $quantity = 1;

        $item = new basketView($product_id, $product_name, $category, $cost, $quantity);
        $serialized = base64_encode(serialize($item));

        echo '<tr>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . $category . '</td>';
        echo '<td>' . "£" . $cost . '</td>';
        echo '<td>';
        echo '<form action="../../src/view/editItem.php" method="post">';
        echo '<button type="submit" name="edit_item" value="' . $product_id . '">Edit Item</button>';
        echo '</form>';
        echo '</td>';
        echo '<td>';
        echo '<form action="../src/controller/basketController.php" method="post">';
        echo '<button type="submit" name="change_status" value="' . $product_id . '">On/Off Sale</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
