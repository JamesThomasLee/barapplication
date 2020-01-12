<?php
include_once '../model/ItemInBasket.php';
session_start();

if(isset($_POST["add_basket"])){
    $item = unserialize(base64_decode($_POST["add_basket"]));
    array_push($_SESSION['basket'], $item);
    header("Location: ../../public/basket.php");
}

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

if(isset($_POST["clear_basket"])){
    $_SESSION['basket'] = array();
    header("Location: ../../public/basket.php");
}

?>

