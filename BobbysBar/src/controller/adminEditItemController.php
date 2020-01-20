<?php
session_start();
include_once '../model/Menu_item.php';
include_once '../model/DBContext.php';

if(isset($_POST["editItem"])){
    $product_id = $_SESSION['product_id'];
    $product_name = $_POST['product_name'];
    $product_supplier = $_POST['product_supplier'];
    $category = $_POST['category'];
    $percentage = $_POST['percentage'];
    $cost = $_POST['cost'];

    $db = new DBContext();
    if($category == "Bar Snacks"){
        $db->updateSnackItem($product_id, $product_name, $product_supplier, $cost);
    }else{
        $db->updateDrinkItem($product_id, $product_name, $product_supplier, $percentage, $cost);
    }
    header("Location: ../../public/admin_pages/adminMenu.php");
}
?>