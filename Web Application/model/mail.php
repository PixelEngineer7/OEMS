<?php
require '../../vendor/PHPMailer/Exception.php';
require '../../vendor/PHPMailer/PHPMailer.php';
require '../../vendor/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



function sendEmailOEMS($to, $subject, $message, $fromEmail, $fromName)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'ems.infinity.networks@gmail.com'; // SMTP username
        $mail->Password = '1andAhalf0.5'; // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption; `ssl` also accepted
        $mail->Port = 465; // TCP port to connect to

        //Recipients
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
