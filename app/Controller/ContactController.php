<?php


namespace App\Controller;


use Core\HTML\BootstrapForm;
use Core\mailer\Mailer;
use Core\Session\Session;

/**
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends AppController
{
    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Contact');
    }

    /**
     * Render the contact page
     */
    public function index()
    {
        if (!empty($_POST)) {
            $adminMail = $this->Contact->AdminMail();
            $mailer = new Mailer();            
            $mailer->sendMail([
                'email' => $adminMail->email,
                'subject' => $_POST['subject'] . " mail envoyé par " . $_POST['username'],
                'message' => $_POST['message'] . "<br><br>Voici le mail de l'utilisateur " . $_POST['username'] . ": " . $_POST['email']
            ]);
            Session::getInstance()->setFlash('success', "Votre email a correctement été envoyé");
            $form = new BootstrapForm($_POST);
            $this->render('contact.index', compact('form'));
        } else {
            $form = new BootstrapForm($_POST);
            $this->render('contact.index', compact('form'));
        }
    }
}		