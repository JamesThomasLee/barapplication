<?php

class Category
{
    private $category;

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }
}