<?php

include_once 'MenuDrink_View.php';
include_once 'MenuSnack_View.php';
include_once 'orderView_Customer.php';
include_once 'orderDetailView_Customer.php';

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

    public function MenuDrink_View(){
        $sql = "SELECT * FROM `drinks`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $menu_items = [];

        // print_r($resultSet);

        if($resultSet){
            foreach($resultSet as $row)
            {
                $menu_item = new MenuDrink_View($row['product_id'], $row['product_name'], $row['category'],
                                                $row['percentage'], $row['cost']);
                $menu_items[] = $menu_item;
            }
        }
        return $menu_items;
    }

    public function MenuSnack_View(){
        $sql = "SELECT * FROM `menusnack_view`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $menu_items = [];

        if($resultSet){
            foreach($resultSet as $row)
            {
                $menu_item = new MenuSnack_View($row['product_id'], $row['product_name'], $row['category'],
                    $row['cost']);
                $menu_items[] = $menu_item;
            }
        }
        return $menu_items;
    }

    public function Order()
    {
        $sql = "";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];

        if($resultSet){
            foreach($resultSet as $row)
            {
                $order = new Order($row['order_id'], $row['customer_id'], $row['table_number']);
                $orders[] = $order;
            }
        }
        return $orders;
    }

    public function Order_details()
    {
        $sql = "";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $order_details = [];

        if($resultSet){
            foreach($resultSet as $row)
            {
                $order_detail = new Order_details($row['order_id'], $row['product_id'], $row['quantity']);
                $order_details[] = $order_detail;
            }
        }
        return $order_details;
    }

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

    public function orderDetails_Retrieve($orderID){
        $sql = "CALL OrderDetailsRetrieve(:orderID)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':orderID', $orderID, PDO::PARAM_STR);

        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $customerOrderDetails = [];

        if($resultSet){
            foreach($resultSet as $row){
                $customerOrderDetail = new orderDetailView_Customer($row['product_id'], $row['product_name'], $row['cost'], $row['quantity']);
                $customerOrderDetails[] = $customerOrderDetail;
            }
        }

        return $customerOrderDetails;
    }

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

    public function insertCustomer($first_name, $surname, $email){
        $sql = "CALL insertCustomer(:first_name, :surname, :email)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $statement->bindParam(':surname', $surname, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);

        $statement->execute();
    }

    public function insertOrder($customer_id, $table_number, $order_time){
        $sql = "CALL insertOrder(:customer_id, :table_number, :date_time)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
        $statement->bindParam(':table_number', $table_number, PDO::PARAM_STR);
        $statement->bindParam(':date_time', $order_time, PDO::PARAM_STR);

        $statement->execute();
    }

    public function insertOrderDetail($order_id, $product_id, $quantity){
        $sql = "CALL insertOrderDetail(:order_id, :product_id, :quantity)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':order_id', $order_id, PDO::PARAM_STR);
        $statement->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $statement->bindParam(':quantity', $quantity, PDO::PARAM_STR);

        $statement->execute();
    }

    public function getLastOrderId(){
        $sql = "SELECT * FROM `lastorderid`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($resultSet as $row)
        {
            $result = $row['LAST_INSERT_ID()'];
        }

        return $result;
    }

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

    public function getCategories(){
        $sql = "SELECT * FROM `getcategories`";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $resultSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];

        if($resultSet){
            foreach($resultSet as $row)
            {
                $category = new Category($row['category']);
                $categories[] = $category;
            }
        }
        return $categories;
    }

    public function addDrinkItem($product_name, $product_supplier, $category, $percentage, $cost){
        /* Commented out due to error - Error - only variables should be passed.
        $sql = "CALL insertDrink(:product_name, :product_supplier, :category, :percentage, :cost)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':product_name', $item->getProductName(), PDO::PARAM_STR);
        $statement->bindParam(':product_supplier', $item->getProductName(), PDO::PARAM_STR);
        $statement->bindParam(':category', $item->getCategory(), PDO::PARAM_STR);
        $statement->bindParam(':percentage', $item->getPercentage(), PDO::PARAM_STR);
        $statement->bindParam(':cost', $item->getCost(), PDO::PARAM_STR);
        */

        $sql = "CALL insertDrink(:product_name, :product_supplier, :category, :percentage, :cost)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':product_name', $product_name, PDO::PARAM_STR);
        $statement->bindParam(':product_supplier', $product_supplier, PDO::PARAM_STR);
        $statement->bindParam(':category', $category, PDO::PARAM_STR);
        $statement->bindParam(':percentage', $percentage, PDO::PARAM_STR);
        $statement->bindParam(':cost', $cost, PDO::PARAM_STR);

        $statement->execute();
    }

    public function addSnackItem($product_name, $product_supplier, $category, $cost){
        /* Commented out due to error - Error - only variables should be passed.
        $sql = "CALL insertSnack(:product_name, :product_supplier, :category, :cost)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':product_name', $item->getProductName(), PDO::PARAM_STR);
        $statement->bindParam(':product_supplier', $item->getProductName(), PDO::PARAM_STR);
        $statement->bindParam(':category', $item->getCategory(), PDO::PARAM_STR);
        $statement->bindParam(':cost', $item->getCost(), PDO::PARAM_STR);
        */

        $sql = "CALL insertDrink(:product_name, :product_supplier, :category, :cost)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':product_name', $product_name, PDO::PARAM_STR);
        $statement->bindParam(':product_supplier', $product_supplier, PDO::PARAM_STR);
        $statement->bindParam(':category', $category, PDO::PARAM_STR);
        $statement->bindParam(':cost', $cost, PDO::PARAM_STR);

        $statement->execute();
    }
}
