<?php
class orderView_Admin
{
    private $order_id;
    private $date_time;
    private $customer_id;
    private $table_number;

    public function __construct($order_id, $date_time, $customer_id, $table_number)
    {
        $this->order_id = $order_id;
        $this->date_time = $date_time;
        $this->customer_id = $customer_id;
        $this->table_number = $table_number;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getDateTime()
    {
        return $this->date_time;
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