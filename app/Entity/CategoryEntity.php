<?php

namespace App\Entity;

use Core\Entity\Entity;

/**
 * Class CategoryEntity
 * @package App\Entity
 */
class CategoryEntity extends Entity
{

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'index.php?p=posts.category&id=' . $this->id;
    }

}