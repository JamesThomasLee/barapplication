<?php
session_start();
include_once '../model/Menu_item.php';
include_once '../model/DBContext.php';
$errors = array();

/*
 * The edit item controller is used to retrieve data from the edit item form and pass the data into an dbcontext update
 * function which will update the database.
 * Here category is used rather than category id as category is prefilled into the category text box.
 * The change status controller also features here. This calls the change status db context function to change the
 * sale_status of an item.
 */

if(isset($_POST["editItem"])){
    $product_id = $_SESSION['product_id'];
    $product_name = trimInputs($_POST['product_name']);
    $product_supplier = trimInputs($_POST['product_supplier']);
    $category = $_POST['category'];
    $percentage = trimInputs($_POST['percentage']);
    $cost = trimInputs($_POST['cost']);

    //validate all inputs
    //carry out validation checks
    $errors = validateProductName($product_name, $errors);
    $errors = validateProductSupplier($product_supplier, $errors);
    //if category has a percentage (not bar snacks)
    if($category != "Bar Snacks"){
        $errors = validatePercentage($percentage, $errors);
    }
    $errors = validateCost($cost, $errors);
    if(errors != null){
        print_r($errors);
        //back button
        echo '<button onclick="history.back()">Go Back</button>';

    }

    //if there are no validation errors, proceed with item update.
    if($errors == null){
        $db = new DBContext();
        //seperate update function for a bar snack due to data differing from a drink.
        if($category == "Bar Snacks"){
            $db->updateSnackItem($product_id, $product_name, $product_supplier, $cost);
        }else{
            $db->updateDrinkItem($product_id, $product_name, $product_supplier, $percentage, $cost);
        }
        header("Location: ../../public/admin_pages/adminMenu.php");
    }

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