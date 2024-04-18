<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'public/plugins/PHPMailer/src/Exception.php';
require 'public/plugins/PHPMailer/src/PHPMailer.php';
require 'public/plugins/PHPMailer/src/SMTP.php';

class AppController
{
    private $request;
    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }
    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }
    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }
    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/' . $template . '.php';
        $output = 'File not found';

        if (file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }


    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
    }

    public function isMod()
    {
        if (($_SESSION['user_status'] === 2) || ($_SESSION['user_status'] === 3)) {
            return true;
        }
    }

    public function isAdmin()
    {
        if (($_SESSION['user_status']) === 3) {
            return true;
        }
    }

    public function logOut()
    {
        // Destroy and unset active session
        session_destroy();
        unset($_SESSION['id']);
        return $this->redirect('/login?msg=logout');
    }

    public function redirect($url)
    {
        header("Location: $url");
    }


    function getIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    public function sendEmail(string $email, string $subject, string $body)
    {
        try {
            $mail = new PHPMailer();

            $mail->isSMTP();
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;

            $mail->Username = 'smigowski99@gmail.com'; // Podaj swój login gmail
            $mail->Password = 'pnlzzkplwfhwyece'; // Podaj swoje hasło do aplikacji

            $mail->CharSet = 'UTF-8';
            $mail->setFrom('no-reply@eventappmanager.pl', 'EventApp ');
            $mail->addAddress($email);
            $mail->addReplyTo('smigowski99@gmail.com', 'Kontakt');

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            //$mail->addAttachment('img/html-ebook.jpg');

            $mail->send();
        } catch (Exception $e) {
            echo "Sending error mail: {$mail->ErrorInfo}";

        }
    }


}