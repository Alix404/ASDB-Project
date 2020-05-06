<?php

namespace App\Model;

use App;
use Core\Database\Database;
use Core\Session\Session;
use Core\String\Str;
use Core\Table\Table;
use Core\validator\Validator;

class UserModel extends Table
{
    protected $table = 'users';

    public function validateRegister()
    {
        $validator = new Validator($_POST);

        $validator->isAlpha('username', 'Votre pseudo est invalide');
        if ($validator->isValid()) {
            $validator->isUniq('username', App::getInstance()->getDb(), 'users', 'Ce pseudo est déjà utilisé');
        }

        $validator->isEmail('email', 'Votre email est invalide');
        if ($validator->isValid()) {
            $validator->isUniq('email', App::getInstance()->getDb(), 'users', 'Cet email est déjà pris');
        }
        $validator->isConfirmed('password', 'Les deux mots de passe ne correspondent pas');
        $errors = $validator->getErrors();
        return $errors;
    }

    public function validateConfirm($db, $user_id, $token)
    {
        $user = $db->prepare('SELECT * FROM users WHERE id = ?', [$user_id], null, true);

        if ($user && $user->confirmation_token == $token) {
            $db->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?', [$user_id]);
            return $user;
        } else {
            return false;
        }
    }

    public function validateResetPassword()
    {
        $validator = new Validator($_POST);
        $validator->isEmail('email', "Cet email n'existe pas");
        $errors = $validator->getErrors();
        return $errors;
    }

    public function validateLogin(Database $db, $username)
    {
        $user = $db->prepare('SELECT * FROM users WHERE (username = :username OR email= :username) AND confirmed_at IS NOT NULL', ['username' => $username], null, true);
        $errors = [];
        if (!$user) {
            $errors[$username] = 'Identifiants incorrect';
        }
        return $errors;
    }

    public function validateAccount()
    {
        $validator = new Validator($_POST);
        $validator->isConfirmed($_POST['password'], 'Les deux mots de passes ne correspondent pas');
        $errors = $validator->getErrors();
        return $errors;
    }

    public function remember(Database $db, $user_id)
    {
        $remember_token = Str::str_random(255);
        $db->prepare('UPDATE users SET remember_token = ? WHERE id = ?', [$remember_token, $user_id]);
        setcookie('remember', $user_id . '//' . $remember_token . sha1($user_id . 'ratonLaveurs'), time() + 60 * 60 * 24 * 7);
    }

    public function checkResetToken(Database $db, $user_id, $token)
    {
        return $db->prepare(
            'SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)',
            [$user_id, $token],
            null,
            true
        );
    }

    public function validateReset(Database $db, $user_id) {
        $validator = new Validator($_POST);
        $validator->isConfirmed('password', 'Les deux mots de passes ne correspondent pas');
        if ($validator->isValid()) {
            $password = App::getAuth()->hashPassword($_POST['password']);
            $db->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE id = ?', [$password, $user_id]);
            return true;
        } else {
            return false;
        }
    }

}