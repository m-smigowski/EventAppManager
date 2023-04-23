<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login()
    {
        if (!$this->isPost()) {
            if($_GET['newpass'] == 'updated'){
                return $this->render('login', ['messages' => ['Hasło zostało zmienione pomyślnie'],
                    'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
            }

            if($_GET['msg'] == 'logout'){
                return $this->render('login', ['messages' => ['Zostałeś wylogowany'],
                    'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
            }

            if($this->isLoggedIn())
            {
                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/main");
            }

            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $user = $this->userRepository->getUser($email);
        if (!$user) {
            return $this->render('login', ['messages' => ['Użytkownik nie został znaleziony w bazie danych, sprawdź login i hasło!'],
            'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"
            ]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['Błędny adres email!'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"
            ]);
        }
        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Błędne hasło!'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"
            ]);
        }

        if ($user->getActive() == 0) {
            return $this->render('login', ['messages' => ['Użytkownik jest nieaktywny'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"
            ]);
        }


        $user_id = $this->userRepository->getUserId($email);

        $_SESSION['user_name'] = $user->getName();
        $_SESSION['user_surname'] = $user->getSurname();
        $_SESSION['user_email'] = $user->getEmail();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_status'] = $user->getStatus();

        $_SESSION['user_profile_photo'] = $this->userRepository->getUserProfileImagePath($user);

        $ip_address = $this->getIPAddress();
        $this->userRepository->updateLastLogin($user,$ip_address);


        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/main");
    }




    public function activate()
    {
        if ($_GET['email'] && $_GET['activation_code']) {
            $email = $_GET['email'];
            $user = $this->userRepository->getUser($email);

            if ($user->getActive() == 1) {
                return $this->render('login', ['messages' => ['Konto zostało już wcześniej aktywowane'],
                    'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
            }
            return $this->render('register-new-pass',['email'=> $email,'activation_code'=>$_GET['activation_code']]);

        }
        if(isset($_POST['password'])&&isset($_POST['confirmed_pass'])&&isset($_POST['activation_code'])&&isset($_POST['email'])){
            if($_POST['password'] == $_POST['confirmed_pass']){

                $user = $this->userRepository->getUser($_POST['email']);
                $user_det_id = $this->userRepository->getUserDetailsId($user);
                $user_id = $this->userRepository->getUserId($_POST['email']);

                $this->userRepository->changePassword(md5($_POST['password']),$user_id);
                $this->userRepository->activeUser($user_det_id, $_POST['activation_code']);
                return $this->render('login', ['messages' => ['Konto zostało aktywowane'],
                    'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);

            }

        }



    }





}