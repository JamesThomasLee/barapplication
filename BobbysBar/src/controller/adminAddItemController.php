<?php
include_once '../model/Menu_item.php';
include_once '../model/DBContext.php';

if(isset($_POST["addItem"])){
    $product_name = $_POST['product_name'];
    $product_supplier = $_POST['product_supplier'];
    $category = $_POST['category'];
    $percentage = $_POST['percentage'];
    $cost = $_POST['cost'];

    if($category == "Bar"){
        echo 1 . "<br>";
        echo $category;
        $item = new MenuSnack_View(0, $product_name, $product_supplier, "Bar Snacks", $cost);
        $db = new DBContext();
        $db->addSnackItem($product_name, $product_supplier, $category,$cost);
    }else{
        echo 2 . "<br>";
        echo $category;
        $item = new MenuDrink_View(0, $product_name, $product_supplier, $category, $percentage, $cost);
        $db = new DBContext();
        $db->addDrinkItem($product_name, $product_supplier, $category, $percentage, $cost);
    }
}
?>