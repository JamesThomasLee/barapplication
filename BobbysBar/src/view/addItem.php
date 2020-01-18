<?php
include '../../src/model/DBContext.php';
include '../../src/model/Category.php';
$db = new DBContext();
$categories = $db->getCategories();

print_r($categories);

?>
s
<form method="post" id="addItem">
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
            echo '<option value=' . $category->getCategory() . '>' . $category->getCategory() . '</option>';
        }
        ?>
    </select>
    <br>
    <label for="percentage">Percentage (if applicable):</label>
    <input type="text" name="percentage" placeholder="Percentage" minlength="1" maxlength="2" autocomplete="off">
    <br>
    <label for="cost">Cost:</label>
    <input type="text" name="cost" placeholder="Cost" minlength="1" maxlength="6" autocomplete="off">
    <br>
    <input type="submit" name="addItem" value="Add Product To Menu">
</form>