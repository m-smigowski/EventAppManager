<?php

class User {
    private $email;
    private $password;
    private $name;
    private $surname;
    private $phone;
    private $status;
    private $active;

    public function __construct($email, $password, $name, $surname,
                                $phone, $status, $active)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->phone = $phone;
        $this->status = $status;
        $this->active = $active;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email): void
    {
        $this->email = $email;}


    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password): void
    {
        $this->password = $password;
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


    public function getPhone()
    {
        return $this->phone;
    }


    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }


    public function getStatus()
    {
        return $this->status;
    }


    public function setStatus($status): void
    {
        $this->status = $status;
    }


    public function getActive()
    {
        return $this->active;
    }


    public function setActive($active): void
    {
        $this->active = $active;
    }




}