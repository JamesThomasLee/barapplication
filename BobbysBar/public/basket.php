<!DOCTYPE html>
<html>
<?php
include_once '../src/model/MenuDrink_View.php';
include 'header.php';
?>


<body>

<?php
$counter = -1;
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
    $counter = $counter + 1;

    $item = new MenuDrink_View($product_id, $product_name, $category, $percentage, $cost);
    $serialized = base64_encode(serialize($item));

    echo '<tr>';
    echo '<td>'. $product_name . '</td>';
    echo '<td>'. "£" . $cost . '</td>';
    echo '<td>'. '<input type="text" name="quantity" value=' . $quantity . '>' . '</td>';
    echo '<td>';
    echo '<form action="../src/controller/basketController.php" method="post">';
    echo '<button type="submit" name="remove_basket" value="' . $product_id . '">Remove Item</button>';
    echo '</form>';
    echo '<td>'. $counter . '</td>';
    echo '<td>';
    echo '</tr>';
}
echo '</table>';

echo '<form action="../src/controller/basketController.php" method="post">';
echo '<button type="submit" name="clear_basket">Clear Basket</button>';
echo '</form>';


?>

</body>

<?php include 'footer.php';?>