<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'Repository.php';

require 'public/plugins/PHPMailer/src/Exception.php';
require 'public/plugins/PHPMailer/src/PHPMailer.php';
require 'public/plugins/PHPMailer/src/SMTP.php';


class EmailRepository extends Repository
{
    public function sendEmail(string $email,string $subject,string $body)
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