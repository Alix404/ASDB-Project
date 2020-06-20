<?php

namespace Core\mailer;


class Mailer
{

    public function sendMail($parameter)
    {
    
 
    error_reporting( E_ALL );

        $param = array(
	    'mail_from'            => 'avprojects ASDB <asdb.contact@avprojects.ovh>',
	    'mail_from_name'       => 'avprojects ASDB',
	    'mailer'               => 'smtp',
	    'mail_set_return_path' => 'false',
	    'smtp_host'            => 'ssl0.ovh.net',
	    'smtp_port'            => '465',
       	    'smtp_ssl'             => 'none',
	    'smtp_auth'            => 'true',
	    'smtp_user'            => 'asdb.contact@avprojects.ovh',
	    'smtp_pass'            => '%68#q&GX&@+c3vX',
            'MIME-Version'         => '1.0',
            'Content-type'         => 'text/html; charset=utf-8', 
        );
       
        $subject_body = $parameter['subject'];
        $subject_message = '=?utf-8?B?' . base64_encode($subject_body) . '?=';
        if (!isset($parameter['user_id']) && (!isset($parameter['token']))) {
            if (!mail($parameter['email'], $subject_message, $parameter['message'], $param)) {
               
                die('mail not sent');
            }
        } else {
            if (!mail($parameter['email'], $subject_message, $parameter['message'] . "<br><br><a href='https://asdb.avprojects.ovh/index.php?p=" . $parameter['link'] . "&id=" . $parameter['user_id'] . "&token=" . $parameter['token'] . "'>" . $parameter['link_message'] . "</a>", $param)) {
                    die('mail not sent');
            }
        }
    }
}
