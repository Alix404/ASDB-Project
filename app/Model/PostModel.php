<?php

namespace App\Model;

use Core\Table\Table;

/**
 * Class PostModel
 * @package App\Model
 */
class PostModel extends Table
{

    /**
     * @var string
     */
    protected $table = 'articles';

    /**
     * @return mixed
     * Return a list of all posts from the more recent to the more ancient
     */
    public function last()
    {
        return $this->query("
            SELECT articles.id, articles.titre, articles.contenu, articles.date_update, categories.titre AS categorie
            FROM articles
            LEFT JOIN categories ON categories_id = categories.id
            ORDER BY articles.date_update DESC
        ");
    }

    /**
     * @param $category_id
     * @return mixed
     *
     * Return a list of all post from the more recent to the more ancient in a certain category
     */
    public function lastByCategory($category_id)
    {
        return $this->query("
            SELECT articles.id, articles.titre, articles.contenu, articles.date_update, categories.titre AS categorie
            FROM articles
            LEFT JOIN categories ON categories_id = categories.id
            WHERE articles.categories_id = ?
            ORDER BY articles.date_update DESC
        ", [$category_id]);
    }

    /**
     * @param $id
     * @return mixed
     * Find all post by their category
     */
    public function findWithCategory($id)
    {
        return $this->query("
            SELECT articles.id, articles.titre, articles.contenu, articles.date_update, categories.titre AS categorie
            FROM articles
            LEFT JOIN categories ON categories_id = categories.id
            WHERE articles.id = ?
        ", [$id], true);
    }

    /**
     * @param $id
     * Delete a comment
     */
    public function deleteComments($id) {
        $comment = $this->query('SELECT * FROM comments WHERE id = ?', [$id], true);
        $this->query('DELETE FROM comments WHERE id = ?', [$id]);
        $this->query('UPDATE comments SET parent_id = ? WHERE parent_id = ?', [$comment->parent_id, $comment->id]);
    }

    /**
     * @param $post_id
     * Delete a post
     */
    public function delete($post_id) {
        $this->query('DELETE FROM articles WHERE id = ?', [$post_id]);
    }


}