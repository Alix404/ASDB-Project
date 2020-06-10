<?php

namespace App\Controller;

use App;
use Core\Database\Database;
use Core\HTML\BootstrapForm;
use Core\Mail\Mail;
use Core\Session\Session;
use Core\String\Str;

/**
 * Class UsersController
 * @package App\Controller
 */
class UsersController extends AppController
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('User');
        $this->loadModel('Subscription');
    }

    /**
     * Validate that the user has confirmed his mail
     */
    public function confirm()
    {
        if (!empty($_GET)) {
            $db = App::getInstance()->getDb();
            $user = $this->User->validateConfirm($db, $_GET['id'], $_GET['token']);
            if ($user) {
                Session::getInstance()->write('auth', $user);
                Session::getInstance()->setFlash('success', 'Votre compte à bien été validé');
                App::getInstance()->redirect('users.login');
            } else {
                Session::getInstance()->setFlash('danger', "Ce token n'est pas valide");
                App::getInstance()->redirect('posts.index');
            }
        } else {
            Session::getInstance()->setFlash('danger', 'Un problème est survenue lors de la récupération de l\'URL');
            App::getInstance()->redirect('posts.index');
        }
    }

    /**
     * Render the login form and login the user
     */
    public function login()
    {
        if ($this->user()) {
            App::getInstance()->redirect('users.account');
        }

        if (!empty($_POST) && !empty($_POST['username'] && !empty($_POST['password']))) {
            $db = App::getInstance()->getDb();
            $errors = $this->User->validateLogin($db, $_POST['username']);
            if (empty($errors)) {
                $user = $db->prepare("SELECT * FROM users WHERE username = :username OR email = :username", ['username' => $_POST['username']], null, true);
                if ($user) {
                    if (password_verify($_POST['password'], $user->password)) {
                        $this->connect($user);
                        if (isset($_POST['remember'])) {
                            $this->User->remember($db, $user->id);
                        }
                        $username = explode('_', $user->username);
                        $pass = $_POST['password'];
                        $password = explode('_', $pass);
                        if ($user->id == 0 && $username[0] == 'Admin' && $password[0] == 'Admin') {
                            Session::getInstance()->setFlash('info', "Vous vous êtes connecté au compte adminisatreur");
                            App::getInstance()->redirect('admin.posts.index');
                        }
                        Session::getInstance()->setFlash('success', "Vous êtes maintenant connecté");
                        App::getInstance()->redirect('users.account');
                    }
                }
            }
            $form = new BootstrapForm($_POST);
            $this->render('users.login', compact('form', 'errors'));
        } else {
            $form = new BootstrapForm($_POST);
            $this->render('users.login', compact('form'));
        }
    }

    /**
     * @return bool
     *
     * Find if a the user is already in the session
     */
    private function user()
    {
        if (Session::getInstance()->read('auth') == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $user
     *
     * Save the current user in the session
     */
    private function connect($user)
    {
        Session::getInstance()->write('auth', $user);
    }

    /**
     * render the account page of the current user
     */
    public function account()
    {
        $this->restrict();
        if (!empty($_POST)) {
            $db = App::getInstance()->getDb();
            $errors = $this->User->validateAccount();
            if (empty($errors)) {
                $user_id = Session::getInstance()->read('auth')->id;
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $db->prepare('UPDATE users SET password = ? WHERE id = ?', [$password, $user_id]);
                Session::getInstance()->setFlash('success', 'Votre mot de passe a bien été mis à jour');
            }
            $form = new BootstrapForm($_POST);
            $this->render('users.account', compact('form', 'errors'));
        } else {
            $form = new BootstrapForm($_POST);
            $this->render('users.account', compact('form'));
        }
    }

    /**
     * Restrict access to certain pages to only logged users
     */
    private function restrict()
    {
        if (!Session::getInstance()->read('auth')) {
            Session::getInstance()->setFlash('danger', "Vous n'avez pas les droits nécessaire pour accèder à cette page");
        }
    }

    /**
     * @param Database $db
     * @return bool
     *
     * Find in cookies the current user to login him
     */
    public function connectFromCookie(Database $db)
    {
        if (isset($_COOKIE['remember']) && !$this->user()) {
            $remember_token = $_COOKIE['remember'];
            $parts = explode('//', $remember_token);
            $user_id = $parts[0];
            $user = $db->prepare('SELECT * FROM users WHERE id = ?', [$user_id], null, true);
            if ($user) {
                $expected = $user_id . '//' . $user->remember_token . sha1($user->id . '183927943167');
                if ($expected == $remember_token) {
                    $this->connect($user);
                    setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                } else {
                    setcookie('remember', NULL, -1);
                }
            } else {
                setcookie('remember', NULL, -1);
            }
            return $user;
        }
        return false;
    }

    /**
     * Logout the current user
     */
    public function logout()
    {
        setcookie('remember', null, -1);
        Session::getInstance()->delete('auth');
        Session::getInstance()->setFlash('success', 'Vous êtes maintentant déconnecté');
        App::getInstance()->redirect('posts.index');
    }

    /**
     * Render the register form and send a mail confirmation to the user
     */
    public function register()
    {
        if (!empty($_POST)) {
            $errors = $this->User->validateRegister($_POST['username'], $_POST['password'], $_POST['email']);
            if (empty($errors)) {
                $user = App::getAuth()->register($_POST['username'], $_POST['password'], $_POST['email']);
                Mail::sendMail([
                        'email' => $_POST['email'],
                        'subject' => "Confirmer votre compte",
                        'message' => "Afin de validé votre inscription, veuillez suivre ce lien",
                        'link' => "users.confirm",
                        'link_message' => "Confirmer mon compte",
                        'user_id' => $user->id,
                        'token' => $user->confirmation_token
                    ]
                );
                Session::getInstance()->setFlash('success', "Un email de confirmation, vous à été envoyé");
                App::getInstance()->redirect('users.login');
            }
            $form = new BootstrapForm($_POST);
            $this->render('users.register', compact('form', 'errors'));
        } else {
            $form = new BootstrapForm($_POST);
            $this->render('users.register', compact('form'));
        }
    }

    /**
     * Render the reset password form and update the user password in the database
     */
    public function reset()
    {
        if (isset($_GET['id']) && isset($_GET['token'])) {
            $db = App::getInstance()->getDb();
            $user = $this->User->checkResetToken($db, $_GET['id'], $_GET['token']);
            if ($user) {
                if (!empty($_POST)) {
                    $valid = $this->User->validateReset($db, $user->id);
                    if ($valid) {
                        Session::getInstance()->setFlash('success', 'Votre mot de passe à bien été modifié');
                        App::getInstance()->redirect('users.login');
                    } else {
                        Session::getInstance()->setFlash('danger', "Une erreur est survenue lors de votre changement de mot de passe");
                        App::getInstance()->redirect('users.login');
                    }
                } else {
                    $form = new BootstrapForm($_POST);
                    $this->render('users.reset', compact('form'));
                }
            } else {
                Session::getInstance()->setFlash('danger', "Ce token n'est pas valide");
                App::getInstance()->redirect('posts.index');
            }
        }
    }


    /**
     * Allows the user to access to the reset page
     */
    public function forget()
    {
        if (!empty($_POST)) {
            $db = App::getInstance()->getDb();
            $errors = $this->User->validateResetPassword();
            if (empty($errors)) {
                $user = $db->prepare('SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL', [$_POST['email']], null, true);
                if ($user) {
                    $reset_token = Str::str_random(60);
                    $db->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?', [$reset_token, $user->id]);
                    Mail::sendMail([
                            'email' => $_POST['email'],
                            'subject' => "Réinitialisation de votre mot de passe",
                            'message' => "Pour réinisialisé votre mot de passe, cliquer sur ce lien",
                            'link' => "users.reset",
                            'link_message' => "Réinsialiser mon mot de passe",
                            'user_id' => $user->id,
                            'token' => $reset_token
                        ]
                    );
                    Session::getInstance()->setFlash('success', 'Les instructions du rappel de mot de passe vous ont été envoyées par email');
                    App::getInstance()->redirect('users.login');
                }
                $form = new BootstrapForm($_POST);
                $this->render('users.forget', compact('form', 'errors'));
            }
        } else {
            $form = new BootstrapForm($_POST);
            $this->render('users.forget', compact('form'));
        }
    }
}
