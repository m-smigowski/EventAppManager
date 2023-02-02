<?php


class Event
{
    private $id;
    private $title;
    private $description;
    private $status;
    private $type;
    private $eventDate;
    private $idAssignedBy;

    public function __construct($id, $title, $description, $status, $type, $eventDate, $idAssignedBy)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->type = $type;
        $this->eventDate = $eventDate;
        $this->idAssignedBy = $idAssignedBy;
    }


    public function getId()
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title): void
    {
        $this->title = $title;
    }


    public function getDescription()
    {
        return $this->description;
    }


    public function setDescription($description): void
    {
        $this->description = $description;
    }


    public function getStatus()
    {
        return $this->status;
    }


    public function setStatus($status): void
    {
        $this->status = $status;
    }


    public function getType()
    {
        return $this->type;
    }


    public function setType($type): void
    {
        $this->type = $type;
    }


    public function getEventDate()
    {
        return $this->eventDate;
    }


    public function setEventDate($eventDate): void
    {
        $this->eventDate = $eventDate;
    }


    public function getIdAssignedBy()
    {
        return $this->idAssignedBy;
    }


    public function setIdAssignedBy($idAssignedBy): void
    {
        $this->idAssignedBy = $idAssignedBy;
    }



}