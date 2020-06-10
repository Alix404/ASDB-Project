<?php

namespace App\Entity;

use Core\Entity\Entity;

/**
 * Class PostEntity
 * @package App\Entity
 */
class PostEntity extends Entity
{

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'index.php?p=posts.show&id=' . $this->id;
    }

    /**
     * @return string
     */
    public function getExtrait()
    {
        $html = '<p>' . substr($this->contenu, 0, 100) . '...</p>';
        $html .= '<p><a href="' . $this->getUrl() . '">Voir la suite</a>';
        return $html;
    }

}