<!DOCTYPE html>
<html>
<?php include '../../public/header.php';
include_once('../model/DBContext.php');

if(isset($_POST["deleteOrder"])) {
    //call db function to collect order details
    $db = new DBContext();
    $results = $db->orderDelete($_SESSION["order_id"]);
    $_SESSION["order_id"] = null;
    header("Location: ../../public/index.php");
}