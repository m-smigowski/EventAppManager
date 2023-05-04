<?php


class Meeting
{
    private $id;
    private $topic;
    private $date;
    private $tasks;
    private $location;
    private $client;

    public function __construct($id, $topic, $date, $tasks, $location, $client)
    {
        $this->id = $id;
        $this->topic = $topic;
        $this->date = $date;
        $this->tasks = $tasks;
        $this->location = $location;
        $this->client = $client;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function setTopic($topic): void
    {
        $this->topic = $topic;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getTasks()
    {
        return $this->tasks;
    }

    public function setTasks($tasks): void
    {
        $this->tasks = $tasks;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location): void
    {
        $this->location = $location;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client): void
    {
        $this->client = $client;
    }

}