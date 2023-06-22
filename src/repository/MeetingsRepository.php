<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/Meeting.php';

class MeetingsRepository extends Repository
{
    public function getClientbyId(int $id_client){
        $stmt = $this->database->connect()->prepare('
        SELECT id,company_name,name,surname,phone FROM clients WHERE id = ?
        ');
        $stmt->execute([$id_client]);
        $company_name = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $company_name;
    }

    public function getClientsOrderByMeetingClient(int $client_id): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM clients ORDER BY id=? ASC
        ');
        $stmt->execute([$client_id]);
        $clients =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($clients as $client){
            $result[] = new Client(
                $client['id'],
                $client['name'],
                $client['surname'],
                $client['description'],
                $client['phone'],
                $client['email'],
                $client['company_name']
            );
        }
        return $result;
    }

    public function getUpcomingMeetings($date): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM meetings WHERE meetings.date >=? ORDER BY meetings.date
        ');
        $stmt->execute([$date]);
        $meetings =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($meetings as $meeting){
            $result[] = new Meeting(
                $meeting['id'],
                $meeting['topic'],
                $meeting['date'],
                $meeting['tasks'],
                $meeting['location'],
                $this->getClientbyId($meeting['id_clients'])
            );
        }
        return $result;
    }

    public function addMeeting(Meeting $meeting): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO meetings(topic,date,tasks,location,id_clients)
            VALUES(?,?,?,?,?);
        ');

        $stmt->execute([
            $meeting->getTopic(),
            $meeting->getDate(),
            $meeting->getTasks(),
            $meeting->getLocation(),
            $meeting->getClient()
        ]);
    }

    public function getMeeting(int $meeting_id): ?Meeting
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM meetings WHERE id = :id
        ');
        $stmt->bindParam(':id', $meeting_id, PDO::PARAM_INT);
        $stmt->execute();

        $meeting = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($meeting == false) {
            return null;
        }

        return new Meeting(
            $meeting['id'],
            $meeting['topic'],
            $meeting['date'],
            $meeting['tasks'],
            $meeting['location'],
            $this->getClientbyId($meeting['id_clients']),
        );
    }

    public function getUsersInMeeting(int $meeting_id): ?array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id_users FROM user_meetings WHERE id_meetings=?
        ');
        $stmt->execute([$meeting_id]);
        $users_id =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users_id == false) {
            return null;
        }

        $arr = array_column($users_id, 'id_users'); // pobieranie wartości z pojedynczej kolumny
        $arr_to_string = implode(',', $arr); // zamiana tablicy na typ string

        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT ud.name,ud.surname,u.id
        FROM user_meetings um
        INNER JOIN meetings m on m.id = um.id_meetings
        INNER JOIN users u on um.id_users = u.id
        INNER JOIN users_details ud on u.id_user_details = ud.id
        WHERE u.id IN ('.$arr_to_string.') and m.id=:meeting_id');

        $stmt->bindParam(':meeting_id', $meeting_id, PDO::PARAM_INT);
        $stmt->execute();
        $usersInMeeting =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($usersInMeeting == false) {
            return null;
        }


        return $usersInMeeting;

    }

    public function getAllMeetingUsers($meeting_id): ?array // Wszyscy użytkownicy, którzy jeszcze nie są przypisani do wydarzenia
    {
        $stmt = $this->database->connect()->prepare('
        SELECT id_users FROM user_meetings WHERE id_meetings=?
        ');
        $stmt->execute([$meeting_id]);
        $users_id =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users_id == false) {
            $stmt = $this->database->connect()->prepare('
            SELECT ud.name,ud.surname,u.id FROM users u LEFT JOIN users_details ud 
            ON u.id_user_details = ud.id WHERE ud.active=1;
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


    public function updateMeetings($client_id,$topic,$date,$location,$tasks,$meeting_id)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE meetings
            SET id_clients=?,topic=?,date=?,location=?,tasks=?
            WHERE id=?
        ');
        $stmt->execute([
            $client_id,
            $topic,
            $date,
            $location,
            $tasks,
            $meeting_id
        ]);


    }

    public function addUserToMeeting(int $user_id, int $meeting_id){
        $stmt = $this->database->connect()->prepare('
            INSERT INTO user_meetings(id_meetings,id_users)
            VALUES(?,?);
        ');

        $stmt->execute([
            $meeting_id,
            $user_id
        ]);
    }

    public function dropUserMeeting(int $user_id, int $meeting_id){
        $stmt = $this->database->connect()->prepare('
            DELETE FROM user_meetings WHERE id_meetings=? AND id_users=?
        ');

        $stmt->execute([
            $meeting_id,
            $user_id,
        ]);
    }





}