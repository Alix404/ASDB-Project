<?php

namespace Core\Mail;


class Mail
{
    static function sendMail($email, $subject, $message, $link, $link_message, $user_id, $token)
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ASDB A new kind of think <asdb.contact@gmail.com>' . "\r\n";
        $subject_body = $subject;
        $subject_message = '=?utf-8?B?' . base64_encode($subject_body) . '?=';
        mail($email, $subject_message, "$message <br><br><a href='http://localhost:8000/index.php?p=$link&id=$user_id&token=$token'>$link_message</a>", $headers);
    }
}