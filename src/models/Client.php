<?php

class Client {
    private $id;
    private $name;
    private $surname;
    private $description;
    private $phone;
    private $email;
    private $company_name;


    public function __construct($id, $name, $surname, $description, $phone, $email, $company_name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->description = $description;
        $this->phone = $phone;
        $this->email = $email;
        $this->company_name = $company_name;
    }


    public function getId()
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name): void
    {
        $this->name = $name;
    }


    public function getSurname()
    {
        return $this->surname;
    }


    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }


    public function getPhone()
    {
        return $this->phone;
    }


    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email): void
    {
        $this->email = $email;
    }


    public function getCompanyName()
    {
        return $this->company_name;
    }


    public function setCompanyName($company_name): void
    {
        $this->company_name = $company_name;
    }



}