<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class UsersPanelController extends AppController
{
    private $userRepository;


    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function usersPanel()
    {
        return $this->render('users-panel');
    }


    public function userEdit()
    {
        $email = $_SESSION['user_name'];
        $user = $this->userRepository->getUser($email);

        $this->render('user-edit', ['user' => $user]);
    }

    public function userEditPass()
    {
        $this->render('user-edit-pass',);
    }


    public function userUpdate()
    {
        $email = $_SESSION['user_name'];
        $id = $_SESSION['user_id'];
        if ($this->isPost()) {
            if (isset($_POST['UserUP'])) {;
                $user = $this->userRepository->getUser($email);
                $user = new User($_POST['email'],$user->getPassword(), $_POST['name'], $_POST['surname'], $_POST['phone'],$user->getStatus(),$user->getActive());
                $_SESSION['user_name'] = $_POST['email'];
                $this->userRepository->updateUser($user,$id);
                return $this->redirect('/usersPanel');
            }
        }
    }


    public function userUpdatePass()
    {
        if (isset($_POST['UserPassUpdate'])) {

                $old_pass = $_POST['old_password'];
                $new_pass = $_POST['new_password'];
                $re_pass = $_POST['confirmed_pass'];

                if(empty($old_pass)||empty($new_pass)||empty($re_pass)) {
                    return $this->render('user-edit-pass',['messages' => ['Uzupełnij wszystkie pola danymi'],
                        'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }

                $email = $_SESSION['user_name'];
                $id = $_SESSION['user_id'];
                $user = $this->userRepository->getUser($email);
                $user_old_pass = $user->getPassword();

                if($re_pass!==$new_pass){
                    return $this->render('user-edit-pass',['messages' => ['Nowe hasła nie są takie same, spróbuj ponownie'],
                    'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }

                if(md5($old_pass) !== $user_old_pass){
                    return $this->render('user-edit-pass',['messages' => ['Poprzednie hasło jest niepoprawne'],
                        'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }

                if($old_pass !== $new_pass ) {
                    $this->userRepository->changePassword(md5($new_pass),$id);
                    return $this->logOut();
                    }else {
                    return $this->render('user-edit-pass', ['messages' => ['Nie możesz zmienic hasła na takie same jak poprzednio'],
                        'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }
        }
    }
}