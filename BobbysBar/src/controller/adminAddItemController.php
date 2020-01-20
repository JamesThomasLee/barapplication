<?php
include_once '../model/Menu_item.php';
include_once '../model/DBContext.php';

if(isset($_POST["addItem"])) {
    $product_name = $_POST['product_name'];
    $product_supplier = $_POST['product_supplier'];
    $category_id = $_POST['category'];
    $percentage = $_POST['percentage'];
    $cost = $_POST['cost'];

    //if category is bar snacks then a seperate function is required as percentage is not passed as a parameter
    if($category_id == 10){
        $item = new MenuSnack_View(0, $product_name, $product_supplier, $category_id, $cost, "ONSALE");
        $db = new DBContext();
        $db->addSnackItem($product_name, $product_supplier, $category_id, $cost, "ONSALE");
    }else{
        $item = new MenuDrink_View(0, $product_name, $product_supplier, $category_id, $percentage, $cost, "ONSALE");
        $db = new DBContext();
        $db->addDrinkItem($product_name, $product_supplier, $category_id, $percentage, $cost, "ONSALE");
    }
    header("Location: ../../public/admin_pages/adminMenu.php");
}
?>