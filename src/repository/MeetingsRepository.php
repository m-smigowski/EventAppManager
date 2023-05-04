<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/Meeting.php';

class MeetingsRepository extends Repository
{
    public function getClientbyId(int $id_client){
        $stmt = $this->database->connect()->prepare('
        SELECT company_name,name,surname FROM clients WHERE id = ?
        ');
        $stmt->execute([$id_client]);
        $company_name = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $company_name;
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




}