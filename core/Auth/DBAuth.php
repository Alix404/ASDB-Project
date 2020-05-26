<?php

namespace Core\Auth;

use Core\Database\Database;
use Core\String\Str;

class DBAuth
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getUserId()
    {
        if ($this->logged()) {
            return $_SESSION['auth'];
        }
        return false;
    }

    public function logged()
    {
        return isset ($_SESSION['auth']);
    }

    public function register($username, $password, $email)
    {
        $password = $this->hashPassword($password);
        $token = Str::str_random(60);
        $this->db->prepare("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?", [
            $username,
            $password,
            $email,
            $token
        ]);
        $id = $this->db->lastInsertId();
        $user = $this->db->prepare("SELECT * FROM users WHERE id = ?", [$id], null, true);
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}