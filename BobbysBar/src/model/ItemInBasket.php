<?php

class ItemInBasket
{
    private $product_id;
    private $product_name;
    private $category;
    private $percentage;
    private $cost;
    private $quantity;

    public function __construct($product_id, $product_name, $category, $percentage, $cost, $quantity)
    {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->category = $category;
        $this->percentage = $percentage;
        $this->cost = $cost;
        $this->quantity=$quantity;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getProductName()
    {
        return $this->product_name;
    }

    public function getCategory(){
        return $this->category;
    }

    public function getPercentage()
    {
        return $this->percentage;
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