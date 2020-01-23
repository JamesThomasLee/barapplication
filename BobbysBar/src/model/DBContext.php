<?php

include_once 'MenuDrink_View.php';
include_once 'MenuSnack_View.php';
include_once 'orderView_Customer.php';
include_once 'orderDetailView_Customer.php';

//DBContext features all of the details required to connect to the database. The construct function is the
//function that will connect to it.
//The rest of the functions in this class are used to manipulate data in the database.
class DBContext
{
    private $db_server = 'Proj-mysql.uopnet.plymouth.ac.uk';
    private $dbUser = 'ISAD251_JLee';
    private $dbPassword = 'ISAD251_22216084';
    private $dbDatabase = 'ISAD251_jlee';
    private $dataSourceName;
    private $connection;

    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;
        try {
            if ($this->connection === null) {
                $this->dataSourceName = 'mysql:dbname=' . $this->dbDatabase . ';host=' . $this->db_server;
                $this->connection = new PDO($this->dataSourceName, $this->dbUser, $this->dbPassword);
                $this->connection->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
            }
        } catch (PDOException $err) {
            echo 'Connection failed: ', $err->getMessage();
        }
    }

    //apiCall is used by the api to return all data from the menu
    public function apiCall(){
        $sql = "SELECT * FROM `menu_coursework`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $resultSet;
    }

    public function Customer()
    {
        $sql = "";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $customers = [];

        if($resultSet){
            foreach($resultSet as $row)
            {
             $customer = new Customer($row['customer_id'], $row['first_name'], $row['surname'], $row['email']);
             $customers[] = $customer;
            }
        }
        return $customers;
    }

    public function Menu_item()
    {
        $sql = "SELECT * FROM `menu_coursework`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $menu_items = [];

        // print_r($resultSet);

        if($resultSet){
            foreach($resultSet as $row)
            {
                $menu_item = new Menu_item($row['product_id'], $row['product_name'], $row['product_supplier'],
                                            $row['category'], $row['percentage'], $row['cost']);
                $menu_items[] = $menu_item;
            }
        }
        return $menu_items;
    }

    /*
    Menu drink view is used by the menu page to call a view that displays only the drinks in the menu.
    This calls only the drinks as snacks do not have a field in the percentage category causing an error when
    trying to return that data.
    */
    public function MenuDrink_View(){
        $sql = "SELECT * FROM `drinks_view`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $menu_items = [];

        // print_r($resultSet);

        if($resultSet){
            foreach($resultSet as $row)
            {
                $menu_item = new MenuDrink_View($row['product_id'], $row['product_name'], $row['product_supplier'], $row['category'],
                                                $row['percentage'], $row['cost'], $row['sale_status']);
                $menu_items[] = $menu_item;
            }
        }
        return $menu_items;
    }

    /*
    This function is almost identical to menu drink view however it returns a view for the admin
    menu instead. This is different as it's required to handle extra data such as product supplier and sale status.
    */
    public function adminMenuDrink_View(){
        $sql = "SELECT * FROM `admindrinks_view`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $menu_items = [];

        // print_r($resultSet);

        if($resultSet){
            foreach($resultSet as $row)
            {
                $menu_item = new MenuDrink_View($row['product_id'], $row['product_name'], $row['product_supplier'], $row['category'],
                    $row['percentage'], $row['cost'], $row['sale_status']);
                $menu_items[] = $menu_item;
            }
        }
        return $menu_items;
    }

    /*
     * Same principle as menu drink view however it returns only the data required for all bar snacks.
     */
    public function MenuSnack_View(){
        $sql = "SELECT * FROM `menusnack_view`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $menu_items = [];

        if($resultSet){
            foreach($resultSet as $row)
            {
                $menu_item = new MenuSnack_View($row['product_id'], $row['product_name'], $row['product_supplier'], $row['category'],
                    $row['cost'], $row['sale_status']);
                $menu_items[] = $menu_item;
            }
        }
        return $menu_items;
    }

    /*
     * Returns all data required for bar snacks in the admin menu. Includes extra data such as product supplier
     * and sale status.
     */
    public function adminMenuSnack_View(){
        $sql = "SELECT * FROM `adminsnacks_view`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $menu_items = [];

        if($resultSet){
            foreach($resultSet as $row)
            {
                $menu_item = new MenuSnack_View($row['product_id'], $row['product_name'], $row['product_supplier'], $row['category'],
                    $row['cost'], $row['sale_status']);
                $menu_items[] = $menu_item;
            }
        }
        return $menu_items;
    }

    /*
     * Order retrieve calls an sql procedure. The order ID is passed into the function with is used by the procedure.
     * The procedure then returns data of the order such as order date/time, table number etc.
     * This data is then returned as a orderview_Customer object.
     */
    public function order_Retrieve($orderID){
        $sql = "CALL OrderRetrieve(:orderID)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':orderID', $orderID, PDO::PARAM_STR);

        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $customerOrder = "";

        if($resultSet){
            foreach($resultSet as $row){
                $customerOrder = new orderView_Customer($row['order_id'], $row['table_number']);
            }
        }

        return $customerOrder;
    }

    /*
     * This function is similar to orderDetails_Retrieve however the procedure returns details of all of the items
     * in the procedure. These are used to create objects orderDetailView_Customer which is then passed into an array list.
     * The more items in the order the more items in the array list.
     */
    public function orderDetails_Retrieve($orderID){
        $sql = "CALL OrderDetailsRetrieve(:orderID)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':orderID', $orderID, PDO::PARAM_STR);

        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $customerOrderDetails = [];

        if($resultSet){
            foreach($resultSet as $row){
                $customerOrderDetail = new orderDetailView_Customer($row['product_name'], $row['cost'], $row['quantity']);
                $customerOrderDetails[] = $customerOrderDetail;
            }
        }

        return $customerOrderDetails;
    }

    /*
     * Check customer is used to call a procedure to check if a customer already exists in the database.
     * If a customer exists then the procedure returns their customer ID.
     */
    public function checkCustomer($email){
        $sql = "CALL checkCustomer(:email)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $result = 0;
        foreach($resultSet as $customer => $id){
            $result = $id;
        }
        return $result;
    }

    /*
     * If a customer does not exist in the database, when they place an order this function is used to input
     * their customer details and call a procedure to insert them into the customer table. I did intend to use OOP to insert
     * a customer object however binding parameters was causing an error.
     */
    public function insertCustomer($first_name, $surname, $email){
        $sql = "CALL insertCustomer(:first_name, :surname, :email)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        $statement->execute();
    }

    /*
     * This function uses user inputted data to insert their order into the orders table.
     */
    public function insertOrder($customer_id, $table_number, $order_time){
        $sql = "CALL insertOrder(:customer_id, :table_number, :date_time)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
        $statement->bindParam(':table_number', $table_number, PDO::PARAM_STR);
        $statement->bindParam(':date_time', $order_time, PDO::PARAM_STR);

        $statement->execute();
    }

    /*
     * This function receives details of an item a user has added to their order. These details are then
     * added to the order details table by a procedure called in this function.
     */
    public function insertOrderDetail($order_id, $product_id, $quantity){
        $sql = "CALL insertOrderDetail(:order_id, :product_id, :quantity)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $statement->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $statement->bindParam(':quantity', $quantity, PDO::PARAM_STR);

        $statement->execute();
    }

    /*
     * This function is used to call a view that returns the order id of the last inserted order.
     * This is used by the order confirmation page to display the details of customers order upon completion.
     */
    public function getLastOrderId($time){
        $sql = "CALL getLastOrder(:time)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':time', $time, PDO::PARAM_STR);

        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $result = 0;
        foreach($resultSet as $order => $id){
            $result = $id;
        }
        return $result;
    }

    /*
     * This function has several stages. The orderid is passed in which is then used to call multiple procedures/sql statements.
     * I do not want data to be permanently deleted from the database. I prevent this by moving any deleted order information
     * such as the order itself and the order details to archive tables. Once this is complete the function then deletes the
     * data from the main order and order details table.
     * I trigger was designed to delete data once it had been moved however this was causing an error due to the trigger firing on
     * the table that the data has been moved from. I removed the trigger and used sql statements to carry out the deletion.
     */
    public function orderDelete($order_id){
        //move order into archive order table (call procedure)
        $sql = "CALL moveOrder(:order_id)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $statement->execute();

        //move orderdetails into archive order details table (call procedure)
        $sql = "CALL moveOrderDetails(:order_id)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $statement->execute();

        //delete from orderdetails table
        //have a trigger to do this however it is causing an error
        $sql = "DELETE FROM orderdetails_coursework WHERE order_id = " . $order_id;
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        //delete from orders table
        //have a trigger to do this however it is causing an error
        $sql = "DELETE FROM orders_coursework WHERE order_id = " . $order_id;
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    /*
     * This function calls a view to return all of the categories from the categories table. This is used by the
     * dropdowns when an admin is adding a new item to prevent a typo from causing an error.
     */
    public function getCategories(){
        $sql = "SELECT * FROM `getcategories`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];

        if($resultSet){
            foreach($resultSet as $row)
            {
                $category = new Category($row['category_id'], $row['category']);
                $categories[] = $category;
            }
        }
        return $categories;
    }

    /*
     * This function passes in user inputted data which is then passed into a sql procedure to insert the data as a new
     * drink item into the menu. Again OOP should have been used however it was causing an error on binding.
     */
    public function addDrinkItem($product_name, $product_supplier, $category_id, $percentage, $cost, $sale_status){
        /* Commented out due to error - Error - only variables should be passed.
        $sql = "CALL insertDrink(:product_name, :product_supplier, :category, :percentage, :cost)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':product_name', $item->getProductName(), PDO::PARAM_STR);
        $statement->bindParam(':product_supplier', $item->getProductName(), PDO::PARAM_STR);
        $statement->bindParam(':category', $item->getCategory(), PDO::PARAM_STR);
        $statement->bindParam(':percentage', $item->getPercentage(), PDO::PARAM_STR);
        $statement->bindParam(':cost', $item->getCost(), PDO::PARAM_STR);
        */

        $sql = "CALL insertDrink(:product_name, :product_supplier, :category_id, :percentage, :cost, :sale_status)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':product_name', $product_name, PDO::PARAM_STR);
        $statement->bindParam(':product_supplier', $product_supplier, PDO::PARAM_STR);
        $statement->bindParam(':category_id', $category_id, PDO::PARAM_STR);
        $statement->bindParam(':percentage', $percentage, PDO::PARAM_STR);
        $statement->bindParam(':cost', $cost, PDO::PARAM_STR);
        $statement->bindParam(':sale_status', $sale_status, PDO::PARAM_STR);

        $statement->execute();
    }

    /*
     * Similar function to add drink item however the parameters are different due to no percentage being required for
     * bar snacks.
     */
    public function addSnackItem($product_name, $product_supplier, $category_id, $cost, $sale_status){
        /* Commented out due to error - Error - only variables should be passed.
        $sql = "CALL insertSnack(:product_name, :product_supplier, :category, :cost)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':product_name', $item->getProductName(), PDO::PARAM_STR);
        $statement->bindParam(':product_supplier', $item->getProductName(), PDO::PARAM_STR);
        $statement->bindParam(':category', $item->getCategory(), PDO::PARAM_STR);
        $statement->bindParam(':cost', $item->getCost(), PDO::PARAM_STR);
        */

        $sql = "CALL insertSnack(:product_name, :product_supplier, :category_id, :cost, :sale_status)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':product_name', $product_name, PDO::PARAM_STR);
        $statement->bindParam(':product_supplier', $product_supplier, PDO::PARAM_STR);
        $statement->bindParam(':category_id', $category_id, PDO::PARAM_STR);
        $statement->bindParam(':cost', $cost, PDO::PARAM_STR);
        $statement->bindParam(':sale_status', $sale_status, PDO::PARAM_STR);

        $statement->execute();
    }

    /*
     * Get product category calls a procedure that is used to return the category of a particular product.
     * This is necessary to pre-fill the text box on update item page. I wanted to pre-fill the text box to prevent
     * the administrator inserting a wrong category causing an error.
     */
    public function getProductCategory($product_id){
        $sql = "CALL getproductcat(:prod_id)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':prod_id', $product_id, PDO::PARAM_STR);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach($resultSet as $row)
            {
                $category = new Category($row['category_id'], $row['category']);
            }
        return $category;
    }

    /*
     * Get item details is used to return the item details of a particular item and its category.
     * This is used when pre-filling an update item form with item data.
     */
    public function getItemDetails($product_id, $categoryID)
    {
        if ($categoryID == 10) {
            $sql = "CALL getItem(:prod_id)";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':prod_id', $product_id, PDO::PARAM_STR);
            $statement->execute();
            $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($resultSet as $row) {
                $item = new MenuSnack_View($row['product_id'], $row['product_name'], $row['product_supplier'], $row['category_id'], $row['cost'], $row['sale_status']);
            }
            return $item;
        }else{
            $sql = "CALL getItem(:prod_id)";
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':prod_id', $product_id, PDO::PARAM_STR);
            $statement->execute();
            $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach($resultSet as $row){
                $item = new MenuDrink_View($row['product_id'], $row['product_name'], $row['product_supplier'],
                    $row['category_id'], $row['percentage'], $row['cost'], $row['sale_status']);
            }
            return $item;
        }
    }

    /*
     * update drink item is used to take all of the data from the admin item update form and pass it into a procedure
     * that updates the particular item in the menu. OOP should have been used however it was causing an error on binding.
     */
    public function updateDrinkItem($product_id, $product_name, $product_supplier, $percentage, $cost){
        $sql = "CALL updateDrinkItem(:prod_id, :prod_name, :prod_sup, :pct, :cst)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':prod_id', $product_id, PDO::PARAM_STR);
        $statement->bindParam(':prod_name', $product_name, PDO::PARAM_STR);
        $statement->bindParam(':prod_sup', $product_supplier, PDO::PARAM_STR);
        $statement->bindParam(':pct', $percentage, PDO::PARAM_STR);
        $statement->bindParam(':cst', $cost, PDO::PARAM_STR);
        $statement->execute();
    }

    /*
     * update drink item is used to take all of the data from the admin item update form and pass it into a procedure
     * that updates the particular item in the menu. OOP should have been used however it was causing an error on binding.
     */
    public function updateSnackItem($product_id, $product_name, $product_supplier, $cost){
        $sql = "CALL updateSnackItem(:prod_id, :prod_name, :prod_sup, :cst)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':prod_id', $product_id, PDO::PARAM_STR);
        $statement->bindParam(':prod_name', $product_name, PDO::PARAM_STR);
        $statement->bindParam(':prod_sup', $product_supplier, PDO::PARAM_STR);
        $statement->bindParam(':cst', $cost, PDO::PARAM_STR);
        $statement->execute();
    }

    /*
     * This function is called when the change status button is pressed on the admin menu. This changes the sale state of
     * an item from ONSALE to OFFSALE or OFFSALE to ONSALE. This sale status value is used by the menu views to determine
     * whether or not an item is displayed on the user menu for sale.
     */
    public function changeItemStatus($product_id){
        $sql = "CALL getItemState(:prod_id)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':prod_id', $product_id, PDO::PARAM_STR);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($resultSet as $row)
        {
            $sale_status = $row['sale_status'];
        }

        if($sale_status == "ONSALE"){
            $newSale_status = "OFFSALE";
        }else{
            $newSale_status = "ONSALE";
        }

        $sql = "CALL changeItemState(:prod_id, :sale_status)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':prod_id', $product_id, PDO::PARAM_STR);
        $statement->bindParam(':sale_status', $newSale_status, PDO::PARAM_STR);
        $statement->execute();
    }

    /*
     * Admin orders is a function used to call a view which displays every order placed. This is used in the admin
     * section of the website.
     */
    public function adminOrders(){
        $sql = "SELECT * FROM `adminorders`";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];

        if($resultSet){
            foreach($resultSet as $row){
                $order = new orderView_Admin($row['order_id'], $row['date_time'], $row['customer_id'], $row['table_number']);
                $orders[] = $order;
            }
        }

        return $orders;
    }
}
