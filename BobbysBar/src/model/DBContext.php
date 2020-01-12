<?php

include_once 'MenuDrink_View.php';
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
                $customerOrderDetail = new orderDetailView_Customer($row['product_name'], $row['cost'], $row['quantity']);
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

}
