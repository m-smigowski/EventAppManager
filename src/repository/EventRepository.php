<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Event.php';

class EventRepository extends Repository
{
    public function getEvent(int $event_id): ?Event
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.events WHERE id = :id
        ');
        $stmt->bindParam(':id', $event_id, PDO::PARAM_INT);
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
            $event['event_start'],
            $event['id_assigned_by'],
            $event['event_end'],
            $event['location']
        );
    }

    public function getEvents(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM events ORDER BY event_start
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
                $event['event_start'],
                $event['id_assigned_by'],
                $event['event_end'],
                $event['location']
            );
        }
        return $result;
    }


    public function getEventByTitle(string $searchString): array
    {
        $searchString = '%'.strtolower($searchString).'%';
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT id,title,description,status,type,created_at as createdAt,
               event_start as eventStart, id_assigned_by as idAssignedBy, 
               event_end as eventEnd FROM events WHERE LOWER(title) LIKE :search
               ORDER BY id
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_INT);
        $stmt->execute();
        return $events =  $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getEventByDate(string $searchDate): array
    {
        //$searchString = '%'.strtolower($searchString).'%';
        $result = [];
        $searchToDate = $searchDate.' 23:59:59.998';
        $stmt = $this->database->connect()->prepare("
        SELECT id,title,description,status,event_start as eventStart,event_end as eventEnd FROM events WHERE event_start BETWEEN :search AND :search_to
        ");

        $stmt->bindParam(':search', $searchDate, PDO::PARAM_INT);
        $stmt->bindParam(':search_to', $searchToDate, PDO::PARAM_INT);
        $stmt->execute();

        return $events =  $stmt->fetchAll(PDO::FETCH_ASSOC);

    }



    public function getLastEventId():int{
        $stmt = $this->database->connect()->prepare('
        SELECT id FROM events ORDER BY id DESC;
        ');
        $stmt->execute();
        $last_event_id =  $stmt->fetchColumn();

        return $last_event_id;
    }

    public function getUpcomingEvents($date): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM events WHERE event_end>=? ORDER BY event_start
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
                $event['event_start'],
                $event['id_assigned_by'],
                $event['event_end'],
                $event['location'],
            );
        }
        return $result;
    }

    public function getUpcomingEventsById($date,$id)/*: array*/
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT id_events FROM user_event WHERE id_users = ?
        ');
        $stmt->execute([$id]);
        $id_events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($id_events == false) {
            return null;
        }

        $arr = array_column($id_events, 'id_events'); // pobieranie wartości z pojedynczej kolumny
        $arr_to_string = implode(',', $arr);

        $stmt = $this->database->connect()->prepare('
        SELECT * FROM events WHERE event_start>=? AND id IN ('.$arr_to_string.')');

        $stmt->execute([$date]);
        $events =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($events == false) {
            return null;
        }

        foreach ($events as $event){
            $result[] = new Event(
                $event['id'],
                $event['title'],
                $event['description'],
                $event['status'],
                $event['type'],
                $event['event_start'],
                $event['id_assigned_by'],
                $event['event_end'],
                $event['location']
            );
        }
        return $result;

    }



    public function getPastEvents($date): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM events WHERE event_end < ? ORDER BY event_start');
        $stmt->execute([$date]);
        $events =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($events as $event){
            $result[] = new Event(
                $event['id'],
                $event['title'],
                $event['description'],
                $event['status'],
                $event['type'],
                $event['event_start'],
                $event['id_assigned_by'],
                $event['event_end'],
                $event['location']
            );
        }
        return $result;
    }


    public function updateEvent(Event $event): void
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE events 
            SET title=?,description=?,status=?,type=?,event_start=?,event_end=?,location=? WHERE id=?;
        ');

        $stmt->execute([
            $event->getTitle(),
            $event->getDescription(),
            $event->getStatus(),
            $event->getType(),
            $event->getEventStart(),
            $event->getEventEnd(),
            $event->getLocation(),
            $event->getId(),
        ]);
    }

    public function addEvent(Event $event): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
            INSERT INTO events(title,description,status,type,created_at,event_start,id_assigned_by,event_end,location)
            VALUES(?,?,?,?,?,?,?,?,?);
        ');

        $assignedById = $_SESSION['user_id'];
        $stmt->execute([
            $event->getTitle(),
            $event->getDescription(),
            $event->getStatus(),
            $event->getType(),
            $date->format('Y-m-d'),
            $event->getEventStart(),
            $assignedById,
            $event->getEventEnd(),
            $event->getLocation(),
        ]);
    }

    public function addClientEvent(int $client_id, int $event_id)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO events_clients(id_events,id_clients)
            VALUES(?,?)
        ');

        $stmt->execute([
            $event_id,
            $client_id
        ]);
    }


    public function removeEvent(int $event_id)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM events WHERE id=:id
        ');
        $stmt->bindParam(':id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
    }


    // Event View Details //


    public function getEventClient(int $event_id)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT c.company_name,c.name, c.surname,c.phone FROM events_clients as ec
        INNER JOIN events e ON ec.id_events = e.id
        INNER JOIN clients c ON ec.id_clients = c.id
        WHERE ec.id_events = ?
        ');

        $stmt->execute([$event_id]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getUsersInEvent(int $event_id): ?array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id_users FROM user_event WHERE id_events=?
        ');
        $stmt->execute([$event_id]);
        $users_id =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users_id == false) {
            return null;
        }

        $arr = array_column($users_id, 'id_users'); // pobieranie wartości z pojedynczej kolumny
        $arr_to_string = implode(',', $arr); // zamiana tablicy na typ string

        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT ud.name,ud.surname, uer.role_name
        FROM user_event
        INNER JOIN events e on e.id = user_event.id_events
        INNER JOIN user_event_roles uer on user_event.id_roles = uer.id
        INNER JOIN users u on user_event.id_users = u.id
        INNER JOIN users_details ud on u.id_user_details = ud.id
        WHERE u.id IN ('.$arr_to_string.') and e.id=:event_id');

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


    public function getAllUsers($event_id): ?array // Wszyscy użytkownicy, którzy jeszcze nie są przypisani do wydarzenia
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id_users FROM user_event WHERE id_events=?
        ');
        $stmt->execute([$event_id]);
        $users_id =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users_id == false) {
            $stmt = $this->database->connect()->prepare('
            SELECT ud.name,ud.surname,u.id FROM users u LEFT JOIN users_details ud 
            ON u.id_user_details = ud.id
        ');
            $stmt->execute();

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($users == false) {
                return null;
            }
            return $users;
        }

        $arr = array_column($users_id, 'id_users'); // pobieranie wartości z pojedynczej kolumny
        $arr_to_string = implode(',', $arr); // zamiana tablicy na typ string

        $stmt = $this->database->connect()->prepare('
            SELECT ud.name,ud.surname,u.id FROM users u LEFT JOIN users_details ud 
            ON u.id_user_details = ud.id WHERE u.id NOT IN ('.$arr_to_string.')
        ');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users == false) {
            return null;
        }

        return $users;

    }

    //Dodawanie nowego pracownika do wydarzenia
    public function addUserEvent(array $name_surname, int $event_id, string $user_role_name){

        $stmt = $this->database->connect()->prepare('
        SELECT ud.id From users_details ud WHERE ud.name=:name AND ud.surname=:surname');

        $stmt->bindParam(':name', $name_surname[0], PDO::PARAM_STR);
        $stmt->bindParam(':surname', $name_surname[1], PDO::PARAM_STR);
        $stmt->execute();
        $id_ud =  $stmt->fetchColumn();

        $stmt = $this->database->connect()->prepare('
        SELECT u.id FROM users u WHERE id_user_details=:id_user');
        $stmt->bindParam(':id_user', $id_ud ,PDO::PARAM_STR);

        $stmt->execute();
        $id_user = $stmt->fetchColumn();;

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


    public function dropUserEvent(int $event_id,string $name,string $surname, string $role_name){

        $stmt = $this->database->connect()->prepare('
        SELECT ud.id From users_details ud WHERE ud.name=:name AND ud.surname=:surname');

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->execute();
        $id_ud =  $stmt->fetchColumn();

        $stmt = $this->database->connect()->prepare('
        SELECT u.id FROM users u WHERE id_user_details=:id_user');
        $stmt->bindParam(':id_user', $id_ud ,PDO::PARAM_STR);
        $stmt->execute();
        $id_user = $stmt->fetchColumn();


        $stmt = $this->database->connect()->prepare('
        SELECT uer.id FROM user_event_roles uer WHERE uer.role_name=:rolename ');

        $stmt->bindParam(':rolename', $role_name, PDO::PARAM_STR);
        $stmt->execute();
        $id_user_role_name = $stmt->fetchColumn();


        $stmt = $this->database->connect()->prepare('
        DELETE FROM user_event WHERE id_users=? AND id_events=? AND id_roles=?
        ');

        $stmt->execute([
            $id_user,
            $event_id,
            $id_user_role_name
        ]);

    }


    public function getEventSchedules($event_id){
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM events_schedules WHERE id_events = :event_id

        ');
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function addEventSchedule($event_id,$title,$description,$start_date,$end_date){
        $stmt = $this->database->connect()->prepare('
        INSERT INTO events_schedules(id_events,title,description,start_date,end_date)
        VALUES (?,?,?,?,?)
        ');
        $stmt->execute([
            $event_id,
            $title,
            $description,
            $start_date,
            $end_date
        ]);
    }

    public function dropEventSchedule($event_id,$event_schedule_id){
        $stmt = $this->database->connect()->prepare('
        DELETE FROM events_schedules WHERE id_events=? AND id=?
        ');
        $stmt->execute([
            $event_id,
            $event_schedule_id
        ]);
    }


    public function addLog($id_users,$log_content){
        $stmt = $this->database->connect()->prepare('
        INSERT INTO events_logs(id_users,log_content,date)
        VALUES (?,?,CURRENT_TIMESTAMP)
        ');
        $stmt->execute([
            $id_users,
            $log_content,
        ]);

    }


    public function getEventsLogs() // Pobieranie wszystkich logów w bazie
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT ud.name, ud.surname, el.log_content, el.date FROM events_logs el 
            INNER JOIN users u ON el.id_users = u.id
            INNER JOIN users_details ud on u.id_user_details = ud.id
            ORDER BY EL.date DESC LIMIT 10

        ');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }




    public function isPastEvent($id)
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT event_end FROM events WHERE id=:id

        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        return $result;
    }






}