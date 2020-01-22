<?php
include_once '../model/ItemInBasket.php';
session_start();

//unserialize items added to basket and push them to the session basket then redirect to basket page.
if(isset($_POST["add_basket"])){
    $item = unserialize(base64_decode($_POST["add_basket"]));
    array_push($_SESSION['basket'], $item);
    header("Location: ../../public/basket.php");
}

//remove basket is called when a user wants to remove an item from the basket.
//A counter is used to identify an item in the basket
//When the user selects an item to remove, the item with the same counter is removed from the basket
if(isset($_POST["remove_basket"])){
    $count = (count($_SESSION['basket']));
    if($count == 1){
        $_SESSION['basket'] = array();
        header("Location: ../../public/basket.php");
    }else{
        $counter = -1;
        foreach ($_SESSION['basket'] as $item) {
            $counter = $counter + 1;
            if($item->getProductId() == $_POST['remove_basket']){
                unset($_SESSION['basket'][$counter]);
            }
        }
        header("Location: ../../public/basket.php");
    }
}

//clear every item from the basket
if(isset($_POST["clear_basket"])){
    $_SESSION['basket'] = array();
    header("Location: ../../public/basket.php");
}

//continue shopping
if(isset($_POST["addToBasket"])){
    header("Location: ../../public/menu.php");
}

?>

