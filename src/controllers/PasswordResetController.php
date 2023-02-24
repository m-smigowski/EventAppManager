<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';


class PasswordResetController extends AppController
{

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }


    public function forgotPass()
    {

        if (!$this->isPost()) {
            return $this->render('forgot-pass');
        }

        $email = $_POST['email'];
        $user = $this->userRepository->getUser($email);

        if (!$user) {
            $this->render('forgot-pass', ['messages' => ['Użytkownik nie istnieje'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
        }

        $selector = bin2hex(random_bytes(8));
        $token = bin2hex(random_bytes(32));
        $expires = date("U") + 1800;

        $url = "http://$_SERVER[HTTP_HOST]";

        // create the forgotpass link
        $forgot_link = $url . "/createNewPassword?selector=" . $selector . "&validator=" . $token;

        $msg = "Twoje hasło zostało zresetowane!<br>
                Żeby ustawić hasło użyj poniższego linku <br>".$forgot_link."<br> Jeżeli nie resetowałeś hasła, zignoruj tego maila.
            ";
        $this->userRepository->pwdDrop($email);
        $this->userRepository->pwdReset($email, $selector, $token, $expires);
        $this->sendEmail($email, 'Hasło zostało zresetowane! Potwierdz reset hasła. ', $msg);


        return $this->render('forgot-pass', ['messages' => ['Sprawdź skrzynkę mailową, żeby zresetować hasło.'],
                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);


    }


    public function createNewPassword()
    {
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];


        if (empty($selector) || empty($validator)) {
            $this->render('forgot-pass');
        } else {
            if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                $this->render('forgot-pass-new', ['validator' => $validator, 'selector' => $selector]);
            }
        }


    }

    public function resetPasswordRequest()
    {

        if (isset($_POST['reset-pwd-submit'])) {
            $selector = $_POST['selector'];
            $validator = $_POST['validator'];
            $password = $_POST['password'];
            $re_password = $_POST['confirmed_pass'];


            $currentDate = date("U");

            if($password !== $re_password){
                $this->render('forgot-pass-new', ['messages' => ['Hasła nie pasują do siebie'],
                    'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }

            if (empty($password)) {
                    $this->render('forgot-pass-new', ['messages' => ['Nie podałeś hasła. Spróbuj ponownie'],
                        'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }


            if (($this->userRepository->pwdSelectorCheck($selector, $currentDate) === false)) {
                            $this->render('forgot-pass', ['messages' => ['Spróbuj ponownie, żadanie z błędnymi danymi.'],
                                'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                };


            $row = $this->userRepository->pwdSelectorCheck($selector, $currentDate);

            if ($validator !== $row['token']) {
                $this->render('forgot-pass', ['messages' => ['Spróbuj ponownie, żadanie z błędnymi danymi.'],
                    'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                } else {
                $email = $row['email'];
                $user = $this->userRepository->getUser($email);

                if($user->getPassword() === md5($password)){
                    $this->render('forgot-pass', ['messages' => ['Nowe haslo nie może być takie jak stare.'],
                        'display' => "var myModal = new bootstrap.Modal(document.getElementById('myModal'));myModal.show()"]);
                }else {
                    $user_id = $this->userRepository->getUserID($email);
                    $this->userRepository->changePassword(md5($password), $user_id); //
                    $this->userRepository->pwdDrop($email); //drop record in pwd_reset table after change
                    $this->redirect('/login?newpass=updated');
                }

                }


        }
    }
}