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

    public function userEdit()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        $email = $_SESSION['user_email'];
        $user = $this->userRepository->getUser($email);


        if($_GET['msg'] == 'updated'){
            return $this->render('user-panel-user-edit', ['user' => $user,'messages' => ['Dane zostały zaaktualizowane.'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if($_GET['msg'] == 'photo_error'){
            return $this->render('user-panel-user-edit', ['user' => $user,'messages' => ['Wybierz poprawne zdjęcie.'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }


        return $this->render('user-panel-user-edit', ['user' => $user]);
    }


    public function  userUpdatePhoto(){
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        if($this->isPost()) {
            $user_id = $_SESSION['user_id'];
            if (is_uploaded_file($_FILES['profile_image']['tmp_name']) && $this->validate($_FILES['profile_image'])) {
                move_uploaded_file(
                    $_FILES['profile_image']['tmp_name'],
                    dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['profile_image']['name']
                );
                if ($_POST['old_photo'] !== 'user.png') {
                    unlink("public/img/app-image/" . $_POST['old_photo'] . "");
                }
                $this->userRepository->updateUserPhoto($_FILES['profile_image']['name'], $user_id);
                $_SESSION['user_profile_photo'] = $_FILES['profile_image']['name'];
                $this->redirect('userEdit'); ;
            }else{
                return $this->redirect('userEdit?msg=photo_error');
            }

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
        $email = $_SESSION['user_email'];
        $id = $_SESSION['user_id'];

        if ($this->isPost()) {
            if (isset($_POST['UserUP'])) {;
                $user = $this->userRepository->getUser($email);
                $user = new User($_POST['email'],$user->getPassword(), $_POST['name'], $_POST['surname'], $_POST['phone'],$user->getStatus(),$user->getActive());
                $ud_id = $this->userRepository->getUserDetailsIdById($id);
                $_SESSION['user_email'] = $_POST['email'];
                $_SESSION['user_name'] = $_POST['name'];
                $_SESSION['user_surname'] = $_POST['surname'];
                $this->userRepository->updateUser($user,$ud_id);
                return $this->redirect('/userEdit?msg=updated');
            }
        }
    }


    public function userEditPass()
    {
        if (!$this->isLoggedIn()) {
            return $this->render('login', ['messages' => ['Nie masz uprawnień do przeglądania tej strony!'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        return $this->render('user-panel-user-edit-pass',);
    }


    public function userUpdatePass()
    {
        if (isset($_POST['UserPassUpdate'])) {

                $old_pass = $_POST['old_password'];
                $new_pass = $_POST['new_password'];
                $re_pass = $_POST['confirmed_pass'];

                if(empty($old_pass)||empty($new_pass)||empty($re_pass)) {
                    return $this->render('user-panel-user-edit-pass',['messages' => ['Uzupełnij wszystkie pola danymi'],
                        'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }

                $email = $_SESSION['user_email'];
                $id = $_SESSION['user_id'];
                $user = $this->userRepository->getUser($email);
                $user_old_pass = $user->getPassword();

                if($re_pass!==$new_pass){
                    return $this->render('user-panel-user-edit-pass',['messages' => ['Nowe hasła nie są takie same, spróbuj ponownie'],
                    'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }

                if(md5($old_pass) !== $user_old_pass){
                    return $this->render('user-panel-user-edit-pass',['messages' => ['Poprzednie hasło jest niepoprawne'],
                        'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }

                if($old_pass !== $new_pass ) {
                    $this->userRepository->changePassword(md5($new_pass),$id);
                    return $this->logOut();
                    }else {
                    return $this->render('user-panel-user-edit-pass', ['messages' => ['Nie możesz zmienic hasła na takie same jak poprzednio'],
                        'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }
        }
    }
}