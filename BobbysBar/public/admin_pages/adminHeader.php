<?php
session_start();
//checks a user has logged in when trying to access an admin page. Redirected out of admin section if not.
if(isset($_SESSION["Authorised"]) && $_SESSION["authorised"] = true){
}else{
    header("Location: ../request.php");
}
?>

<head>
    <title>Bar Ordering System</title>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../assets/css/myStylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../../assets/css/stylesheet.css">

    <div class="hero-image">
        <div class="hero-text">
            <h1>Bobby's Bar</h1>
        </div>
    </div>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="adminControlPanel.php" class="nav-item nav-link">Control Panel</a>
            </div>

            <div class="navbar-nav ml-auto">
                <a href="../../src/controller/adminLogOut.php" class="nav-item nav-link">Log Out</a>
            </div>
        </div>
    </nav>


</head>

