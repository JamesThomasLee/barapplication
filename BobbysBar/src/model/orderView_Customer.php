<?php

class orderView_Customer
{
    private $order_id;
    private $table_number;

    public function __construct($order_id, $table_number)
    {
        $this->order_id = $order_id;
        $this->table_number = $table_number;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getTableNumber()
    {
        return $this->table_number;
    }
}