<?php
include_once '../model/DBContext.php';
include 'header.php';

if(isset($_POST["deleteOrder"])) {
    //call db function to collect order details
    $db = new DBContext();
    $results = $db->orderDelete($_SESSION["order_id"]);
    echo "<p>Order Cancelled.</p>";
    $_SESSION["order_id"] = null;
}