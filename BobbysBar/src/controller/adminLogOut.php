<?php
session_start();
//change authorisation session variable to false and redirect to public section of the site.
$_SESSION["authorised"] = false;
header("Location: ../../public/request.php");