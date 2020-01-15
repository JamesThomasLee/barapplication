<?php

class basketView
{
    private $product_id;
    private $product_name;
    private $category;
    private $cost;

    public function __construct($product_id, $product_name, $category, $cost)
    {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->category = $category;
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

    public function getCost()
    {
        return $this->cost;
    }
}