<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class UsersPanelController extends AppController
{
    private $userRepository;

    const UPLOAD_DIRECTORY = '/../public/img/app-image/';
    const MAX_FILE_SIZE = 2024 * 2024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];


    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function usersPanel()
    {
        $email = $_SESSION['user_email'];
        $user = $this->userRepository->getUser($email);

        $this->render('users-panel', ['user' => $user]);
    }


    public function userEditPass()
    {
        $this->render('user-edit-pass',);
    }


    public function  userUpdatePhoto(){
        if($this->isPost()){
            $profile_photo_src = $_POST['profile_image'];
            $user_id = $_SESSION['user_id'];

            if (is_uploaded_file($_FILES['image']['tmp_name']) && $this->validate($_FILES['image'])) {
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['image']['name']
                );
            }
            //$this->userRepository->userUpdatePhoto($profile_photo_src,$user_id);


        }

    }

    private function validate($file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'Plik jest za duży, zmiejsz jego rozmiar';
            return false;
        }

        if (!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'Typ pliku nie jest wspierany.';
            return false;
        }

        return true;
    }

    public function userUpdate()
    {
        $email = $_SESSION['user_name'];
        $id = $_SESSION['user_id'];

        if ($this->isPost()) {
            if (isset($_POST['UserUP'])) {;
                $user = $this->userRepository->getUser($email);
                $user = new User($_POST['email'],$user->getPassword(), $_POST['name'], $_POST['surname'], $_POST['phone'],$user->getStatus(),$user->getActive());
                $ud_id = $this->userRepository->getUserDetailsIdById($id);
                $_SESSION['user_name'] = $_POST['email'];
                $this->userRepository->updateUser($user,$ud_id);
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