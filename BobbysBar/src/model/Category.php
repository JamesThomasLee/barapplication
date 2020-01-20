<?php

class Category
{
    private $category_id;
    private $category;

    public function __construct($category_id, $category)
    {
        $this->category_id = $category_id;
        $this->category = $category;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getCategory()
    {
        return $this->category;
    }
}