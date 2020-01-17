<?php

class orderDetailView_Customer
{
    protected $product_id;
    protected $product_name;
    protected $cost;
    protected $quantity;

    public function __construct($product_id, $product_name, $cost, $quantity)
    {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->cost = $cost;
        $this->quantity=$quantity;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getProduct_Name()
    {
        return $this->product_name;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}