<!DOCTYPE html>
<html>
<?php include '../../public/header.php';
include_once('../model/DBContext.php');

/*
 * When a user wants to cancel their order, delete order is called.
 * The order id is passed in to the order delete db function via a sesssion variable.
 * The order is then placed into the archived tables.
 */

if(isset($_POST["deleteOrder"])) {
    //call db function to collect order details
    $db = new DBContext();
    $results = $db->orderDelete($_SESSION["order_id"]);
    $_SESSION["order_id"] = null;
    header("Location: ../../public/index.php");
}