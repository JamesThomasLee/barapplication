<!DOCTYPE html>
<html>
<?php include 'header.php';
//include the login form
include '../src/view/loginForm.php';
$errors = array();
/*
 * Check that credentials match the coded credentials.
 * Credentials are hard coded into the system however in a larger project administrators would have individual accounts
 * in a database and their credentials would be compared to these credentials.
 */
if(isset($_POST['login'])){
    //strip inputs
    $username = trimInputs($_POST['username']);
    $password = trimInputs($_POST['password']);

    //validate inputs
    $errors = validateUsername($username, $errors);
    $errors = validatePassword($password, $errors);

    //if credentials match
    if($username == "Admin" && $password == "Password"){
        $_SESSION["Authorised"] = true;
        header("Location: admin_pages/adminControlPanel.php");
        $errors = null;
    }else{
        array_push($errors, "Incorrect credentials.");
    }
    printErrors($errors);
}

function validateUsername($username, $errors){
    if(empty($username)){
        array_push($errors, "*Please enter a username.");
    }
    return $errors;
}

function validatePassword($password, $errors){
    if(empty($password)){
        array_push($errors, "*Please enter a password.");
    }
    return $errors;
}

function trimInputs($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

//print errors
function printErrors($errors){
    foreach($errors as $error){
        echo $error . "<br>";
    }
}
?>

<?php include 'footer.php';?>