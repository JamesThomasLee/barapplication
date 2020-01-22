<?php
include_once '../model/Menu_item.php';
include_once '../model/DBContext.php';

/*
 * This controller is used when an admin adds an item to the database. When the add button is clicked this controller
 * is called. It retrieves all of the item data from the form and creates an item - ether a drink view item or a snack
 * view item. These parameters are passed into a dbcontext function to be added to the database.
 * OOP should be used however bindingparams was causing an error.
 * An if statement is used to ensure the correct category is input. Category id 10 is bar snacks. Anything else = a drink.
 * Cancel button is included to cancel adding an item and returning to the menu.
 */

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

if(isset($_POST['cancel'])){
    header("Location: ../../public/admin_pages/adminMenu.php");
}
?>