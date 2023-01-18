<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Event.php';

class EventRepository extends Repository
{
    public function getEvent(int $id): ?Event
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.events WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($event == false) {
            return null;
        }

        return new Event(
            $event['id'],
            $event['title'],
            $event['description'],
            $event['status'],
            $event['type'],
            $event['event_date'],
        );
    }

    public function getEvents(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM events ORDER BY event_date
        ');
        $stmt->execute();
        $events =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event){
            $result[] = new Event(
                $event['id'],
                $event['title'],
                $event['description'],
                $event['status'],
                $event['type'],
                $event['event_date'],
            );
        }

        return $result;
    }

    public function getUpcomingEvents($date): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM events WHERE event_date>=? ORDER BY event_date
        ');
        $stmt->execute([$date]);
        $events =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event){
            $result[] = new Event(
                $event['id'],
                $event['title'],
                $event['description'],
                $event['status'],
                $event['type'],
                $event['event_date'],
            );

        }

        return $result;
    }


    public function getPastEvents($date): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM events WHERE event_date < ? ORDER BY event_date
        ');
        $stmt->execute([$date]);
        $events =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event){
            $result[] = new Event(
                $event['id'],
                $event['title'],
                $event['description'],
                $event['status'],
                $event['type'],
                $event['event_date'],
            );

        }

        return $result;
    }


    public function updateEvent(Event $event): void
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE events 
            SET title=?,description=?,status=?,type=?,event_date=? WHERE id=?;
        ');

        $stmt->execute([
            $event->getTitle(),
            $event->getDescription(),
            $event->getStatus(),
            $event->getType(),
            $event->getEventDate(),
            $event->getId(),

        ]);
    }

    public function addEvent(Event $event): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
            INSERT INTO events(title,description,status,type,created_at,event_date, id_assigned_by)
            VALUES(?,?,?,?,?,?,?);
        ');

        $assignedById = $_SESSION['user_id'];
        $stmt->execute([
            $event->getTitle(),
            $event->getDescription(),
            $event->getStatus(),
            $event->getType(),
            $date->format('Y-m-d'),
            $event->getEventDate(),
            $assignedById
        ]);

    }

    public function removeEvent(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM events WHERE id=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

    }


}