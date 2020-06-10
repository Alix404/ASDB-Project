<?php


namespace App\Model;


use Core\Mail\Mail;
use Core\Table\Table;

/**
 * Class SubscriptionModel
 * @package App\Model
 */
class SubscriptionModel extends Table
{
    /**
     * @param $user_id
     * @param $category_id
     *
     * Add a subscription in the database
     */
    public function subscribe($user_id, $category_id)
    {
        $this->query('INSERT INTO subscription SET user_id = ?, category_id = ?', [$user_id, $category_id]);
    }

    /**
     * @param $user
     * @param $category_id
     * @return mixed
     *
     * Find if a user is already subscribed
     */
    public function isAlreadySubscribed($user, $category_id)
    {
        return $this->query('SELECT * FROM subscription WHERE user_id = ? AND category_id = ?', [$user->id, $category_id], true);
    }

    /**
     * @param $category_id
     * @return bool
     *
     * Find all subcribed users with the category id
     */
    public function whoIsSubscribed($category_id)
    {

        $entries = $this->query('SELECT user_id FROM subscription WHERE category_id = ?', [$category_id], false, false);
        if (!empty($entries) && $entries != false) {
            foreach ($entries as $user) {
                $users[] = $this->query('SELECT * FROM users WHERE id = ?', [$user->user_id], true, false);
            }
            return $users;
        }
        return false;
    }

    /**
     * @param $users
     * @param $category
     *
     * Send a mail to all users who are subscribed to this category
     */
    public function alertUser($users, $category)
    {
        foreach ($users as $user) {
            Mail::sendMail([
                'email' => $user->email,
                'subject' => 'Un nouvel article vous attend',
                'message' => "Coucou $user->username, j'ai une bonne nouvelle !! <br><br> Un nouvel article est apparu dans la categorie <em><strong>$category->titre</strong></em>, je vous souhaite une bonne lecture =D"
            ]);
        }
    }
}