<?php


class Event
{
    private $id;
    private $title;
    private $description;
    private $status;
    private $type;
    private $eventStart;
    private $idAssignedBy;
    private $eventEnd;
    private $location;

    public function __construct($id, $title, $description, $status, $type, $eventStart, $idAssignedBy, $eventEnd, $location)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->type = $type;
        $this->eventStart = $eventStart;
        $this->idAssignedBy = $idAssignedBy;
        $this->eventEnd = $eventEnd;
        $this->location = $location;

    }


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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getEventStart()
    {
        return $this->eventStart;
    }

    /**
     * @param mixed $eventStart
     */
    public function setEventStart($eventStart): void
    {
        $this->eventStart = $eventStart;
    }

    /**
     * @return mixed
     */
    public function getIdAssignedBy()
    {
        return $this->idAssignedBy;
    }

    /**
     * @param mixed $idAssignedBy
     */
    public function setIdAssignedBy($idAssignedBy): void
    {
        $this->idAssignedBy = $idAssignedBy;
    }

    /**
     * @return mixed
     */
    public function getEventEnd()
    {
        return $this->eventEnd;
    }

    /**
     * @param mixed $eventEnd
     */
    public function setEventEnd($eventEnd): void
    {
        $this->eventEnd = $eventEnd;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

}