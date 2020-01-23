<form  action="../src/controller/placeOrderController.php" method="post">
    <p>Please enter customer details below: </p>
    <label for="first_name">First Name: </label>
    <input type="text" name="first_name" placeholder="First Name" minlength="1" maxlength="20" autocomplete="off">
    <br>
    <label for="surname">Surname: </label>
    <input type="text" name="surname" placeholder="Surname" minlength="1" maxlength="25" autocomplete="off">
    <br>
    <label for="email">Email: </label>
    <input type="text" name="email" placeholder="Email" minlength="1" maxlength="35" autocomplete="off">
    <br>
    <label for="table_number">Table Number: </label>
    <select name="table_number">
        <?php
        //drop down box for 30 tables in the bar
        $i = 1;
        for($i = 1; $i < 31; $i++){
            echo '<option value=' . $i . '>' . $i . '</option>';
        }
        ?>
    </select>
    <br>
    <br>
    <p>By ticking this box you are confirming you have read and agree to our terms and conditions
        which can be found here.
    <input type="checkbox" name="terms" value="accepted">
    <br>
        <br>
    <input type="submit" id=orderButton name="placeOrder" value="Place Order">
</form>