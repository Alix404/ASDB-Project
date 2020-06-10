<?php


namespace App\Entity;


use Core\Entity\Entity;

/**
 * Class UserEntity
 * @package App\Entity
 */
class UserEntity extends Entity
{
    /**
     * @return string
     */
    public function getUrl()
    {
        return 'index.php?p=posts.user&id=' . $this->id;
    }
}