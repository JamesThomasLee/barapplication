<!DOCTYPE html>
<html>
<?php
include_once '../src/model/MenuDrink_View.php';
include 'header.php';
?>


<body>

<?php

$tableString = '<table border="1">';
$tableString .= '<tr>';
$tableString .= '<th> Your Basket:</th>';
$tableString .= '</tr>';
echo $tableString;
echo '<td>'. "Item" . '</td>';
echo '<td>'. "Cost" . '</td>';
echo '<td>'. "Quantity" . '</td>';

foreach ($_SESSION['basket'] as $item){
    $product_id = $item->getProductId();
    $product_name = $item->getProductName();
    $category = $item->getCategory();
    $percentage = $item->getPercentage();
    $cost = $item->getCost();
    $quantity = 1;

    echo '<tr>';
    echo '<td>'. $product_name . '</td>';
    echo '<td>'. "£" . $cost . '</td>';
    echo '<td>'. $quantity . '</td>';
    echo '</tr>';
}
echo '</table>';

?>

</body>

<?php include 'footer.php';?>