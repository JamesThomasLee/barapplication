<?php
include_once '../model/Menu_item.php';
include_once '../model/DBContext.php';
$errors = array();
/*
 * This controller is used when an admin adds an item to the database. When the add button is clicked this controller
 * is called. It retrieves all of the item data from the form and creates an item - ether a drink view item or a snack
 * view item. These parameters are passed into a dbcontext function to be added to the database.
 * OOP should be used however bindingparams was causing an error.
 * An if statement is used to ensure the correct category is input. Category id 10 is bar snacks. Anything else = a drink.
 * Cancel button is included to cancel adding an item and returning to the menu.
 */

if(isset($_POST["addItem"])) {
    $product_name = trimInputs($_POST['product_name']);
    $product_supplier = trimInputs($_POST['product_supplier']);
    $category_id = trimInputs($_POST['category']);
    $percentage = trimInputs($_POST['percentage']);
    $cost = trimInputs($_POST['cost']);

    //carry out validation checks
    $errors = validateProductName($product_name, $errors);
    $errors = validateProductSupplier($product_supplier, $errors);
    //if category has a percentage (not bar snacks)
    if($category_id != 10){
        $errors = validatePercentage($percentage, $errors);
    }
    $errors = validateCost($cost, $errors);
    if(errors != null){
        print_r($errors);
        //back button
        echo '<button onclick="history.back()">Go Back</button>';

    }

    //if checks are passed then proceed
    if($errors == null){
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
}

if(isset($_POST['cancel'])){
    header("Location: ../../public/admin_pages/adminMenu.php");
}

//strip inputs
function trimInputs($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

//check product name for empty field or string too long
function validateProductName($productName, $errors){
    if(empty($productName)){
        array_push($errors, "*Please enter a product name.");
    }else{
        if(strlen($productName) > 29){
            array_push($errors, "*Product name too long");
        }
    }
    return $errors;
}

//check product supplier for empty field or string too long
function validateProductSupplier($productSupplier, $errors){
    if(empty($productSupplier)){
        array_push($errors, "*Please enter a product supplier.");
    }else{
        if(strlen($productSupplier) > 39){
            array_push($errors, "*Product supplier too long");
        }
    }
    return $errors;
}

//check product percentage for empty field, or non numeric
function validatePercentage($percentage, $errors){
    if(empty($percentage)){
        array_push($errors, "*Please enter a percentage");
    }else{
        if(!is_numeric($percentage)){
            array_push($errors, "*Please enter a valid percentage");
        }
    }
    return $errors;
}

//check product cost for empty field, or non numeric
function validateCost($cost, $errors){
    if(empty($cost)){
        array_push($errors, "*Please enter a cost");
    }else{
        if(!is_numeric($cost)){
            array_push($errors, "*Please enter a valid cost");
        }
    }
    return $errors;
}
?>