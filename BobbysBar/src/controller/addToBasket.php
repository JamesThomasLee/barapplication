<?php
session_start();

if(isset($_POST["add_basket"])){
    array_push($_SESSION['basket'], $_POST['add_basket'], 1);
    header("Location: ../../public/basket.php");

}

?>