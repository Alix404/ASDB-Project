<?php

namespace App\Model;

use Core\Table\Table;

class PostModel extends Table
{

    protected $table = 'articles';

    public function last()
    {
        return $this->query("
            SELECT articles.id, articles.titre, articles.contenu, articles.date_update, categories.titre AS categorie
            FROM articles
            LEFT JOIN categories ON categories_id = categories.id
            ORDER BY articles.date_update DESC
        ");
    }

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

    public function findWithCategory($id)
    {
        return $this->query("
            SELECT articles.id, articles.titre, articles.contenu, articles.date_update, categories.titre AS categorie
            FROM articles
            LEFT JOIN categories ON categories_id = categories.id
            WHERE articles.id = ?
        ", [$id], true);
    }

    public function deleteComments($id) {
        $comment = $this->query('SELECT * FROM comments WHERE id = ?', [$id], true);
        $this->query('DELETE FROM comments WHERE id = ?', [$id]);
        $this->query('UPDATE comments SET parent_id = ? WHERE parent_id = ?', [$comment->parent_id, $comment->id]);
    }

    public function delete($post_id) {
        $this->query('DELETE FROM articles WHERE id = ?', [$post_id]);
    }


}