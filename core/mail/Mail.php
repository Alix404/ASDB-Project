<?php

namespace Core\Mail;


class Mail
{
    static function sendMail(array $parameter)
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ASDB A new kind of think <asdb.contact@gmail.com>' . "\r\n";
        $subject_body = $parameter['subject'];
        $subject_message = '=?utf-8?B?' . base64_encode($subject_body) . '?=';

        if (!isset($parameter['user_id']) && (!isset($parameter['token']))) {
            mail($parameter['email'], $subject_message, $parameter['message'], $headers);
        } else {
            mail($parameter['email'], $subject_message, $parameter['message'] . "<br><br><a href='http://localhost:8000/index.php?p=" . $parameter['link'] . "&id=" . $parameter['user_id'] . "&token=" . $parameter['token'] . "'>" . $parameter['link_message'] . "</a>", $headers);
        }

    }
}