<?php
include_once '../model/MenuDrink_View.php';
session_start();

if(isset($_POST["add_basket"])){
    $item = unserialize(base64_decode($_POST["add_basket"]));
    array_push($_SESSION['basket'], $item);
    header("Location: ../../public/basket.php");
    //print_r($_SESSION['basket']);
}

?>