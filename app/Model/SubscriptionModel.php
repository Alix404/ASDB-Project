<?php


namespace App\Model;


use Core\Table\Table;

class SubscriptionModel extends Table
{
    public function subscribe($user_id, $category_id) {
        $this->query('INSERT INTO subscription SET user_id = ?, category_id = ?', [$user_id, $category_id]);
    }
}