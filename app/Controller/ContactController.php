<?php


namespace App\Controller;


use Core\HTML\BootstrapForm;
use Core\Mail\Mail;

class ContactController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Contact');
    }

    public function index()
    {
        if (!empty($_POST)) {
            $adminMail = $this->Contact->AdminMail();
            Mail::sendMail([
                'email' => $adminMail->email,
                'subject' => $_POST['subject'] . " mail envoyé par " . $_POST['username'],
                'message' => $_POST['message'] . "<br><br>Voici le mail de l'utilisateur " . $_POST['username'] . ": " . $_POST['email']
            ]);
            $form = new BootstrapForm($_POST);
            $this->render('contact.index', compact('form'));
        } else {
            $form = new BootstrapForm($_POST);
            $this->render('contact.index', compact('form'));
        }
    }
}