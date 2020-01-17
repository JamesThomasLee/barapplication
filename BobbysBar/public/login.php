<!DOCTYPE html>
<html>
<?php include 'header.php';?>

<body>
<?php include '../src/view/loginForm.php';?>
</body>

<?php

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == "Admin" && $password == "Password"){
        $_SESSION["Authorised"] = true;
        header("Location: admin_pages/adminControlPanel.php");
    }else{
        echo "Incorrect Credentials";
    }
}

?>

<?php include 'footer.php';?>