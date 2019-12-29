<?php

class MenuDrink_View
{
    private $product_id;
    private $product_name;
    private $percentage;
    private $cost;

    public function __construct($product_id, $product_name, $percentage, $cost)
    {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->percentage = $percentage;
        $this->cost = $cost;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getProductName()
    {
        return $this->product_name;
    }

    public function getPercentage()
    {
        return $this->percentage;
    }

    public function getCost()
    {
        return $this->cost;
    }
}