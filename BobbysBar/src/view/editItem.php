<?php
include_once '../../public/admin_pages/adminHeader.php';
include_once '../model/DBContext.php';

if(isset($_POST["edit_item"])){
    $product_id = $_POST["edit_item"];
    $db = new DBContext();
    $category = $db->getProductCategory($product_id);
    $results = $db->getItemDetails($product_id, $category);

    $product_name = $results->getProductName();
    $product_supplier = $results->getProductSupplier();
    if($category != "Bar Snacks"){
        $percentage = $results->getPercentage();
    }else{
        $percentage = "Not Applicable";
    }
    $cost = $results->getCost();
}

?>

<form method="post" id="addItem" action="../../src/controller/adminEditItemController.php">
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" value="<?php echo $product_name; ?>" minlength="1" maxlength="30" autocomplete="off">
    <br>
    <label for="product_supplier">Product Supplier:</label>
    <input type="text" name="product_supplier" value="<?php echo $product_supplier; ?>" minlength="1" maxlength="30" autocomplete="off">
    <br>
    <label for="product_supplier">Category:</label>
    <input type="text" name="category" value="<?php echo $category; ?>" minlength="1" maxlength="30" disabled autocomplete="off">
    <br>
    <label for="percentage">Percentage (if applicable):</label>
    <input type="text" name="percentage" value="<?php echo $percentage; ?>" minlength="1" maxlength="2" autocomplete="off"
    <?php if($category == "Bar Snacks"){echo " disabled";} ?>>
    <br>
    <label for="cost">Cost:</label>
    <input type="text" name="cost" value="<?php echo $cost; ?>" minlength="1" maxlength="6" autocomplete="off">
    <br>
    <input type="button" name="cancel" value="Cancel">
    <input type="submit" name="editItem" value="Update Item">
</form>
