<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/UserInEvent.php';

class AdminPanelRepository extends Repository
{
    public function addRole(string $role_name)
    {

        $stmt = $this->database->connect()->prepare('
            INSERT INTO user_event_roles (role_name)
            VALUES (?);
        ');

            $stmt->execute([
                $role_name,
            ]);

    }

    public function dropRole(string $role_name)
    {

        $stmt = $this->database->connect()->prepare('
        DELETE FROM user_event_roles WHERE role_name=?
        ');

        $stmt->execute([
            $role_name,
        ]);

    }






}