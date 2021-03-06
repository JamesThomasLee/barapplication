<?php
include '../../src/model/DBContext.php';
include '../../src/model/Category.php';
$db = new DBContext();
$categories = $db->getCategories();

/*
 * This is a form used to allow an admin to enter data about a new item.
 * getCategories is used to populate a select tag with existing categories.
 */

?>
<div class="admin-form">
    <form method="post" id="addItem" action="../../src/controller/adminAddItemController.php">
        <h3>Add Item to Menu</h3>
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" placeholder="Product Name" minlength="1" maxlength="30" autocomplete="off">
        <br>
        <label for="product_supplier">Product Supplier:</label>
        <input type="text" name="product_supplier" placeholder="Product Supplier" minlength="1" maxlength="30" autocomplete="off">
        <br>
        <label for="category">Category:</label>
        <select name="category">
            <?php
            foreach($categories as $category){
                echo '<option value=' . $category->getCategoryId() . '>' . $category->getCategory() . '</option>';
            }
            ?>
        </select>
        <br>
        <label for="percentage">Percentage (if applicable):</label>
        <input type="text" name="percentage" placeholder="Percentage" minlength="1" maxlength="4" autocomplete="off">
        <br>
        <label for="cost">Cost:</label>
        <input type="text" name="cost" placeholder="Cost" minlength="1" maxlength="6" autocomplete="off">
        <br>
        <br>
        <div class="admin-buttons">
            <input type="submit" name="cancel" value="Cancel">
            <input type="submit" name="addItem" value="Add Product To Menu">
        </div>
    </form>
</div>
