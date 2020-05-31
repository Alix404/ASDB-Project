<?php


namespace App\Model;


use Core\Table\Table;

class ContactModel extends Table
{
    public function adminMail() {
        return $this->query('SELECT email FROM users WHERE id = ?', [1], true, false);
    }
}