<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function SendEmailNofication($receive, $subject, $message)
{

    $GmailAddress = 'mailserverwap@gmail.com';
    $GmailAccessToken = 'UUVFeE1qTTBOVFkzT0RrPQ==';

    $mail = new PHPMailer();
    $mail->isSMTP();

    //Enable SMTP debugging
    //SMTP::DEBUG_OFF = off (for production use)
    //SMTP::DEBUG_CLIENT = client messages
    //SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_OFF;

    $mail->Host = 'smtp.gmail.com';

    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $GmailAddress;

    //Password to use for SMTP authentication
    $mail->Password = base64_decode(base64_decode($GmailAccessToken));

    $mail->setFrom($GmailAddress, 'THPT Liên Hà');
    $mail->addReplyTo($GmailAddress, 'THPT Liên Hà');

    //Set who the message is to be sent to
    $mail->addAddress($receive);

    $mail->CharSet = PHPMailer::CHARSET_UTF8;
    //Set the subject line
    $mail->Subject = $subject;

    $mail->msgHTML($message);

    $mail->AltBody = $message;

    //send the message, check for errors
    if (!$mail->send()) {
        return array('error' => 'Lỗi gửi email: ' . $mail->ErrorInfo);
    } else {
        return array('success' => true);
    }
}
