<?php


namespace App\Model;


use Core\Table\Table;
use Exception;

/**
 * Class CommentModel
 * @package App\Model
 */
class CommentModel extends Table
{
    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @param $post_id
     * @return mixed
     *
     * Find all comments by their post
     */
    public function validCommentsByPosts($post_id)
    {

        return $this->query('SELECT * FROM comments WHERE post_id = ? AND comments.validated = 1', [$post_id]);
    }

    /**
     * @param $content
     * @param $username
     * @param $post_id
     * @throws Exception
     *
     * Add the comment in database
     */
    public function submitComment($content, $username, $post_id)
    {
        $parent_id = $this->parentComment();
        $this->query('INSERT INTO comments SET content = ?, username = ?, post_id = ?, parent_id = ?', [$content, $username, $post_id, $parent_id]);
    }

    /**
     * @return int|mixed
     * @throws Exception
     *
     * Find the parent comment of a comment
     */
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

    /**
     * @return mixed
     *
     * Return all comments, validated or not yet
     */
    public function allComments()
    {
        return $this->query('SELECT * FROM comments WHERE comments.validated = 0');
    }

    /**
     * @param $comment_id
     * @param $validation
     *
     * Update the validation of a comment
     */
    public function validateThis($comment_id, $validation) {
        $this->query('UPDATE comments SET validated = ? WHERE id = ?', [$validation, $comment_id]);
    }
}