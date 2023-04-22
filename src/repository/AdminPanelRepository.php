<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Client.php';
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


    public function getAllUsers()
    {
        $stmt = $this->database->connect()->prepare('
        SELECT u.id,u.id_user_details,u.email,ud.name,ud.surname,ud.phone,ud.status,ud.active,ud.last_login,ud.ip_address 
        FROM users_details ud INNER JOIN users u on ud.id = u.id_user_details
        ');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function getUserById($user_id)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT u.id,u.id_user_details,u.email,ud.name,ud.surname,ud.phone,ud.status,ud.active,ud.last_login,ud.ip_address 
        FROM users_details ud INNER JOIN users u on ud.id = u.id_user_details WHERE u.id = :user_id
        ');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $user;
    }

    public function updateUser($name, $surname, $email, $phone, $status, $active, $id, $id_user_details)
    {

        $stmt = $this->database->connect()->prepare('
            UPDATE users_details SET name=?, surname=?, phone=?,status=?,active=? WHERE id=?
        ');

        $stmt->execute([
            $name,
            $surname,
            $phone,
            $status,
            $active,
            $id_user_details
        ]);

        $stmt = $this->database->connect()->prepare('
            UPDATE users SET email=? WHERE id=?
        ');

        $stmt->execute([
            $email,
            $id
        ]);
    }


    public function dropUser($id, $id_user_details)
    {

        $stmt = $this->database->connect()->prepare('
            DELETE FROM users  WHERE id=? AND id_user_details=?
        ');

        $stmt->execute([
            $id,
            $id_user_details
        ]);

    }

    public function getLastClientId():int{
        $stmt = $this->database->connect()->prepare('
            SELECT id FROM clients ORDER BY id DESC;
            ');
        $stmt->execute();
        $lastClientId =  $stmt->fetchColumn();

        return $lastClientId;
    }

    public function getClients(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM clients ORDER BY id
        ');
        $stmt->execute();
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

    public function getClient(int $client_id): ?Client
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM clients WHERE id=?
        ');
        $stmt->execute([$client_id]);

        $client =  $stmt->fetch(PDO::FETCH_ASSOC);
        return new Client(
                $client['id'],
                $client['name'],
                $client['surname'],
                $client['description'],
                $client['phone'],
                $client['email'],
                $client['company_name']
            );


    }


    public function addClient(Client $client): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO clients(name,surname,description,phone,email,company_name)
            VALUES(?,?,?,?,?,?);
        ');

        $stmt->execute([
            $client->getName(),
            $client->getSurname(),
            $client->getDescription(),
            $client->getPhone(),
            $client->getEmail(),
            $client->getCompanyName()
        ]);

    }

    public function updateClient(Client $client): void
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE clients SET name=?,surname=?,description=?,phone=?,email=?,company_name=?
            WHERE id=?
        ');

        $stmt->execute([
            $client->getName(),
            $client->getSurname(),
            $client->getDescription(),
            $client->getPhone(),
            $client->getEmail(),
            $client->getCompanyName(),
            $client->getId()
        ]);

    }


    public function dropClient(int $client_id)
    {

        $stmt = $this->database->connect()->prepare('
        DELETE FROM clients WHERE id=?
        ');

        $stmt->execute([
            $client_id
        ]);

    }


}