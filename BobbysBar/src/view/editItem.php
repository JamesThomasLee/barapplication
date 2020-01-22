<?php
include_once '../../public/admin_pages/adminHeader.php';
include_once '../model/DBContext.php';
include_once '../model/Category.php';

/*
 * This form is used to edit an item.
 * When this form is loaded, the php functions below collect the data on a specific item to pre-populate the form.
 * Category cannot be edited.
 * Percentage cannot be edited if category = bar snacks.
 */

if(isset($_POST["edit_item"])){
    $product_id = $_POST["edit_item"];
    //used by controller to update item with new values
    $_SESSION['product_id'] = $product_id;
    $db = new DBContext();
    $category = $db->getProductCategory($product_id);
    $categoryID = $category->getCategoryId();
    $categoryName = $category->getCategory();
    $results = $db->getItemDetails($product_id, $categoryID);

    $product_name = $results->getProductName();
    $product_supplier = $results->getProductSupplier();
    if($categoryID != 10){
        $percentage = $results->getPercentage();
    }else{
        $percentage = "Not Applicable";
    }
    $cost = $results->getCost();
}

?>

<form method="post" id="editItem" action="../../src/controller/adminEditItemController.php">
    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" value="<?php echo $product_name; ?>" minlength="1" maxlength="30" autocomplete="off">
    <br>
    <label for="product_supplier">Product Supplier:</label>
    <input type="text" name="product_supplier" value="<?php echo $product_supplier; ?>" minlength="1" maxlength="30" autocomplete="off">
    <br>
    <label for="product_supplier">Category:</label>
    <input type="text" name="category" value="<?php echo $categoryName; ?>" minlength="1" maxlength="30" readonly autocomplete="off">
    <br>
    <label for="percentage">Percentage (if applicable):</label>
    <input type="text" name="percentage" value="<?php echo $percentage; ?>" minlength="1" maxlength="2" autocomplete="off"
    <?php if($category == "Bar Snacks"){echo " readonly";} ?>>
    <br>
    <label for="cost">Cost:</label>
    <input type="text" name="cost" value="<?php echo $cost; ?>" minlength="1" maxlength="6" autocomplete="off">
    <br>
    <input type="submit" name="cancel" value="Cancel">
    <input type="submit" name="editItem" value="Update Item">
</form>
