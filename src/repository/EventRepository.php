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
        SELECT * FROM events WHERE event_date < ? ORDER BY event_date');
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


    // Event View Details //


    public function getIdUsersInEvent($id) // Pobieranie Id użytkowników przypisanych do danego wydarzenia
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id_users FROM user_event WHERE id_events=?
        ');
        $stmt->execute([$id]);
        $users =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users == false) {
            return null;
        }
        return $users;
    }

    public function getUsersInEvent($arr_to_string,int $event_id): ?array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT ud.name,ud.surname, uer.role_name
        FROM((user_event
            INNER JOIN events e on e.id = user_event.id_events
            INNER JOIN user_event_roles uer on user_event.id_roles = uer.id
            INNER JOIN users u on user_event.id_users = u.id
            INNER JOIN users_details ud on u.id = ud.id
            )) WHERE u.id IN ('.$arr_to_string.') and e.id=:event_id');


        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        $usersInEvent =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($usersInEvent == false) {
            return null;
        }

        foreach ($usersInEvent as $userInEvent){
            $result[] = new UserInEvent(
                $userInEvent['name'],
                $userInEvent['surname'],
                $userInEvent['role_name'],
            );
        }

        return $result;

    }


    public function getAllRoles() // Pobieranie wszystkich rol w bazie
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM user_event_roles 
        ');
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Dodawanie nowego pracownika do wydarzenia
    public function addUserEvent(array $name_surname, int $event_id, string $user_role_name){

        $stmt = $this->database->connect()->prepare('
        SELECT u.id FROM((users u
            INNER JOIN users_details ud on u.id = ud.id
            )) WHERE ud.name=:name AND ud.surname=:surname');

        $stmt->bindParam(':name', $name_surname[0], PDO::PARAM_STR);
        $stmt->bindParam(':surname', $name_surname[1], PDO::PARAM_STR);
        $stmt->execute();

        $id_user =  $stmt->fetchColumn();

        $stmt = $this->database->connect()->prepare('
        SELECT uer.id FROM user_event_roles uer WHERE uer.role_name=:rolename ');

        $stmt->bindParam(':rolename', $user_role_name, PDO::PARAM_STR);

        $stmt->execute();
        $id_user_role_name = $stmt->fetchColumn();


        $stmt = $this->database->connect()->prepare('
        INSERT INTO user_event(id_users,id_events,id_roles)
        VALUES (?,?,?)
        ');

        $stmt->execute([
            $id_user,
            $event_id,
            $id_user_role_name
        ]);


    }




}