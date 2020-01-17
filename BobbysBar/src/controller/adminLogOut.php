<?php
session_start();
$_SESSION["authorised"] = false;
header("Location: ../../public/index.php");