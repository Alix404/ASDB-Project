<?php


namespace App\Controller\admin;


use App;
use Core\Session\Session;

class CommentsController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Comment');
    }

    public function validation()
    {
        $comments = $this->Comment->allComments();
        if (!empty($comments)) {
            foreach ($comments as $comment) {
                $comments_by_id[$comment->id] = $comment;
            }
            if (isset($_POST['validation']) && $_POST['validation'] == 1) {
                $this->Comment->validateThis($_POST['comment_id'], $_POST['validation']);
                unset($_POST['validation']);
                Session::getInstance()->setFlash('success', "Le commentaire à bien été validé");
                App::getInstance()->redirect('admin.comments.validation');
            } else {
                $this->render('admin.comments.validation', compact('comments'));
            }
        } else {
            Session::getInstance()->setFlash('info', "Vous n'avez aucun nouveau commentaire à valider");
            $this->render('admin.comments.validation', compact('comments'));
        }
    }
}