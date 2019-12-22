<?php

class Order_details
{
    private $order_id;
    private $product_id;
    private $quantity;

    public function __construct($order_id ,$product_id, $quantity)
    {
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}