<?php


namespace App\Model;


use Core\Table\Table;

/**
 * Class ContactModel
 * @package App\Model
 */
class ContactModel extends Table
{
    /**
     * @return mixed
     * Find the admin email
     */
    public function adminMail() {
        return $this->query('SELECT email FROM users WHERE id = ?', [1], true, false);
    }
}