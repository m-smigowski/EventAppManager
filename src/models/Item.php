<?php

class Item
{
    private $id;
    private $name;
    private $description;
    private $image;
    private $barcode;
    private $quantity;

    public function __construct($id, $name, $description, $image, $barcode, $quantity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->barcode = $barcode;
        $this->quantity = $quantity;
    }



    /**
     * @param $id
     * @param $name
     * @param $description
     * @param $image
     * @param $barcode
     * @param $quantity
     */


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param mixed $barcode
     */
    public function setBarcode($barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }



}