<?php

namespace App\Model;

use Core\Table\Table;

class CategoryModel extends Table
{
    protected $table = 'categories';

    public function categoryNameFromId($category_id)
    {
        return $this->query('SELECT titre FROM categories WHERE id = ?', [$category_id], true, true);
    }
}