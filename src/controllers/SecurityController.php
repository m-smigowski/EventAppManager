<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/EmailRepository.php';

class SecurityController extends AppController
{

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->emailRepository = new EmailRepository();
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
        $user_id = $this->userRepository->getUserId($email);

        $_SESSION['user_name'] = $email;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_status'] = $user->getStatus();


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


        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/main");
    }


    public function send_activation_email(string $email, string $activation_code): void
    {
        $url = "http://$_SERVER[HTTP_HOST]";
        // create the activation link
        $activation_link = $url."/activate?email=$email&activation_code=$activation_code";

        // set email subject & body
        $subject = 'Aktywuj swoje konto';
        $body ='
            Witaj,
            w celu aktywacji swojego konta, klikjnij w poniższy link '.
            $activation_link;

        // send the email
        $this->emailRepository->sendEmail($email, $subject, $body);

    }


    public function register(){

        if(!$this->isAdmin()){

            return $this->logOut();

        }

        if (!$this->isPost()) {
            return $this->render('register');
        }



        $email = $_POST['email'];
        $user_exist = $this->userRepository->getUser($email);

        if ($user_exist) {
            return $this->render('register', ['messages' => ['Użytkownik z tym emailem już istnieje'],
                'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"
            ]);
        }

        $password = $_POST['password'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $phone = $_POST['phone'];
        $active = 0;
        $status = 1;

        $activation_code = md5($email);
        $this->send_activation_email($email,$activation_code);

        $user = new User($email, md5($password), $name, $surname,$phone,$status,$active);
        $this->userRepository->addUser($user,$activation_code);


        $this->render('login', ['messages' => ['Sprawdź e-mail w celu potwierdzenia rejestracji'],
           'display'=>"var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);

    }


    public function activate()
    {
        if ($_GET['email'] && $_GET['activation_code']) {
            $email = $_GET['email'];
            $user = $this->userRepository->getUser($email);
            $user_det_id = $this->userRepository->getUserDetailsId($user);

            if ($user->getActive() == 1) {
                return $this->render('login', ['messages' => ['Konto zostało już wcześniej aktywowane'],
                    'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
            } else {
                $this->userRepository->activeUser($user_det_id, $_GET['activation_code']);
                return $this->render('login', ['messages' => ['Konto zostało aktywowane'],
                    'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
            }

        }
    }





}