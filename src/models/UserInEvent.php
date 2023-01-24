<?php

class UserInEvent
{
    private $name;
    private $surname;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getRoleName()
    {
        return $this->role_name;
    }

    /**
     * @param mixed $role_name
     */
    public function setRoleName($role_name): void
    {
        $this->role_name = $role_name;
    }
    private $role_name;

    /**
     * @param $name
     * @param $surname
     * @param $role_name
     */
    public function __construct($name, $surname, $role_name)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->role_name = $role_name;
    }


}