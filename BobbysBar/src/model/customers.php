<?php

class customers
{
    private $customer_id;
    private $first_name;
    private $surname;
    private $email;

    public function __construct($customer_id, $first_name, $surname, $email)
    {
        $this->customer_id = $customer_id;
        $this->first_name = $first_name;
        $this->surname = $surname;
        $this->email = $email;
    }

    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getEmail()
    {
        return $this->email;
    }
}