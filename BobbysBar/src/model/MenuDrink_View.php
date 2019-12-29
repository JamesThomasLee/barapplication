<?php

class MenuDrink_View
{
    private $product_id;
    private $product_name;
    private $category;
    private $percentage;
    private $cost;

    public function __construct($product_id, $product_name, $category, $percentage, $cost)
    {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->category = $category;
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
}