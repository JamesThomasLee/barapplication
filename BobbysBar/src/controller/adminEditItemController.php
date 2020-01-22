<?php
session_start();
include_once '../model/Menu_item.php';
include_once '../model/DBContext.php';

/*
 * The edit item controller is used to retrieve data from the edit item form and pass the data into an dbcontext update
 * function which will update the database.
 * Here category is used rather than category id as category is prefilled into the category text box.
 * The change status controller also features here. This calls the change status db context function to change the
 * sale_status of an item.
 */

if(isset($_POST["editItem"])){
    $product_id = $_SESSION['product_id'];
    $product_name = $_POST['product_name'];
    $product_supplier = $_POST['product_supplier'];
    $category = $_POST['category'];
    $percentage = $_POST['percentage'];
    $cost = $_POST['cost'];

    $db = new DBContext();
    //seperate update function for a bar snack due to data differing from a drink.
    if($category == "Bar Snacks"){
        $db->updateSnackItem($product_id, $product_name, $product_supplier, $cost);
    }else{
        $db->updateDrinkItem($product_id, $product_name, $product_supplier, $percentage, $cost);
    }
    header("Location: ../../public/admin_pages/adminMenu.php");
}

//used to change the sale status of an item
if(isset($_POST["change_status"])){
    $product_id = $_POST['change_status'];
    $db = new DBContext();
    $db->changeItemStatus($product_id);
    header("Location: ../../public/admin_pages/adminMenu.php");
}

//cancel edit and return to menu without saving.
if(isset($_POST['cancel'])){
    header("Location: ../../public/admin_pages/adminMenu.php");
}

?>