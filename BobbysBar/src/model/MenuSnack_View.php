<?php

class MenuSnack_View
{
    private $product_id;
    private $product_name;
    private $product_supplier;
    private $category;
    private $cost;

    public function __construct($product_id, $product_name, $product_supplier, $category, $cost)
    {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->product_supplier = $product_supplier;
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

    public function getProductSupplier()
    {
        return $this->product_supplier;
    }

    public function getCategory(){
        return $this->category;
    }

    public function getCost()
    {
        return $this->cost;
    }
}