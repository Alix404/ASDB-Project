<?php

namespace App\Model;

use Core\Table\Table;

/**
 * Class CategoryModel
 * @package App\Model
 */
class CategoryModel extends Table
{
    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @param $category_id
     * @return mixed
     *
     * Find the category's name from its id
     */
    public function categoryNameFromId($category_id)
    {
        return $this->query('SELECT titre FROM categories WHERE id = ?', [$category_id], true, true);
    }


    public function delete($post_id) {
        $this->query('DELETE FROM categories WHERE id = ?', [$post_id]);
    }
}