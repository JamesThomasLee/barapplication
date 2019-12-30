<!DOCTYPE html>
<html>
<?php
include_once('header.php');
include_once('../src/model/DBContext.php');
include_once('../src/model/MenuDrink_View.php');
?>

<body>
<?php

    $db = new DBContext();
    $results = $db->MenuDrink_View();

    if($results){
        $tableString = '<table border="1">';
        $tableString .= '<tr>';
        $tableString .= '<th> Drinks</th>';
        $tableString .= '</tr>';
        echo $tableString;

        foreach ($results as $result){
            $product_id = $result->getProductId();
            $product_name = $result->getProductName();
            $category = $result->getCategory();
            $percentage = $result->getPercentage();
            $cost = $result->getCost();

            echo '<tr>';
            echo '<td>'. $product_name . '</td>';
            echo '<td>'. $category . '</td>';
            echo '<td>'. $percentage . "%" . '</td>';
            echo '<td>'. "£" . $cost . '</td>';
            echo '<td>';
            echo '<form action="../src/controller/addToBasket.php" method="post">';
            echo '<button type="submit" name="add_basket" value="' . $product_id . '">Add to Basket</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }



?>

</body>

<?php include 'footer.php';?>