<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/UserInEvent.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users u LEFT JOIN users_details ud 
            ON u.id_user_details = ud.id WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }
        return new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname'],
            $user['phone'],
            $user['status'],
            $user['active']
        );
    }


    public function getUserById(int $assignedBy_id): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users u LEFT JOIN users_details ud 
            ON u.id_user_details = ud.id WHERE u.id = :id
        ');
        $stmt->bindParam(':id', $assignedBy_id, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname'],
            $user['phone'],
            $user['status'],
            $user['active']

        );
    }


    public function addUser(User $user,string $activation_code)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users_details (name, surname, phone,active,activation_code)
            VALUES (?, ?, ?, ?, ?)
        ');
            $stmt->execute([
                $user->getName(),
                $user->getSurname(),
                $user->getPhone(),
                $user->getActive(),
                $activation_code
        ]);

        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, password, id_user_details)
            VALUES (?, ?, ?)
        ');
            $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $this->getUserDetailsId($user),
        ]);
    }


    public function updateLastLogin($user,$ip_address){
        $user_id_det = $this->getUserDetailsId($user);

        $date = date('Y-m-d H:i:s');

        $stmt = $this->database->connect()->prepare('
            UPDATE users_details SET last_login = :date, ip_address = :ip_address WHERE id = :id
        ');

        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id_det, PDO::PARAM_STR);
        $stmt->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);
        $stmt->execute();

    }

    public function getUserDetailsId(User $user): int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users_details WHERE name = :name AND surname = :surname AND phone = :phone
        ');
        $stmt->bindParam(':name', $user->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':surname', $user->getSurname(), PDO::PARAM_STR);
        $stmt->bindParam(':phone', $user->getPhone(), PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }

    public function getUserProfileImagePath(User $user)
    {
        $uid = $this->getUserDetailsId($user);

        $stmt = $this->database->connect()->prepare('
            SELECT profile_photo FROM users_details WHERE id = :uid
        ');

        $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['profile_photo'];
    }

    public function getUserDetailsIdById(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id_user_details FROM users WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data['id_user_details'];
    }


    public function getUserId(string $email)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT users.id FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }




    public function updateUser(User $user,int $id)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE users_details SET name=?, surname=?, phone=? WHERE id=?
        ');

            $stmt->execute([
                $user->getName(),
                $user->getSurname(),
                $user->getPhone(),
                $id
        ]);

       $stmt = $this->database->connect()->prepare('
            UPDATE users SET email=?, password=? WHERE id_user_details=?
        ');

        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $this->getUserDetailsId($user)
        ]);
    }

    public function updateUserPhoto(string $profile_photo_src,int $user_id)
    {
        $uid = $this->getUserDetailsIdById($user_id);
        $stmt = $this->database->connect()->prepare('
            UPDATE users_details SET profile_photo=? WHERE id=?
        ');

        $stmt->execute([
            $profile_photo_src,
            $uid
        ]);
    }


    public function changePassword(string $new_pass,int $id)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE users SET password=?  WHERE id=?
        ');

        $stmt->execute([
            $new_pass,
            $id
        ]);
    }

    public function activeUser(int $user_det_id, string $activation_code)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE users_details SET active=1,activated_at = CURRENT_TIMESTAMP WHERE id=? and activation_code=?
        ');

        $stmt->execute([
            $user_det_id,
            $activation_code
        ]);
    }


    public function pwdDrop(string $email){
        $stmt = $this->database->connect()->prepare('
            DELETE FROM pwd_reset  WHERE email=?
        ');
        $stmt->execute([
            $email,
        ]);
    }

    public function pwdReset(string $email,string $selector,$token,string $expires){
        $stmt = $this->database->connect()->prepare('
            INSERT INTO pwd_reset (email, selector, token, expires_time)
            VALUES (?,?,?,?)
        ');
        $stmt->execute([
            $email,
            $selector,
            $token,
            $expires
        ]);
    }

    public function pwdSelectorCheck(string $selector,string $currentDate){
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM pwd_reset WHERE selector=:selector AND expires_time >= :expires_time
        ');
        $stmt->bindParam(':selector', $selector, PDO::PARAM_STR);
        $stmt->bindParam(':expires_time', $currentDate, PDO::PARAM_STR);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;


    }






}