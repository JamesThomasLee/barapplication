<?php

class order
{
    private $order_id;
    private $customer_id;
    private $table_number;

    public function __construct($order_id ,$customer_id, $table_number)
    {
        $this->order_id = $order_id;
        $this->customer_id = $customer_id;
        $this->table_number = $table_number;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function getTableNumber()
    {
        return $this->table_number;
    }
}