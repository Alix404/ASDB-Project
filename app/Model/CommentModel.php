<?php


namespace App\Model;


use Core\Table\Table;
use Exception;

class CommentModel extends Table
{
    protected $table = 'comments';

    public function validCommentsByPosts($post_id)
    {

        return $this->query('SELECT * FROM comments WHERE post_id = ? AND comments.validated = 1', [$post_id]);
    }

    public function submitComment($content, $username, $post_id)
    {
        $parent_id = $this->parentComment();
        $this->query('INSERT INTO comments SET content = ?, username = ?, post_id = ?, parent_id = ?', [$content, $username, $post_id, $parent_id]);
    }

    private function parentComment()
    {
        $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
        if ($parent_id != 0) {
            $comment = $this->query('SELECT id FROM comments WHERE id = ?', [$parent_id], true);
            if ($comment == false) {
                throw new Exception('Ce parent n\'existe pas');
            }
            return $parent_id;
        } else {
            return $parent_id;
        }
    }

    public function allComments()
    {
        return $this->query('SELECT * FROM comments WHERE comments.validated = 0');
    }

    public function validateThis($comment_id, $validation) {
        $this->query('UPDATE comments SET validated = ? WHERE id = ?', [$validation, $comment_id]);
    }
}