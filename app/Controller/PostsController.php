<?php

namespace App\Controller;

use App;
use Core\HTML\BootstrapForm;
use Core\Session\Session;

class PostsController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Post');
        $this->loadModel('Category');
        $this->loadModel('Comment');

    }

    public function index()
    {
        $posts = $this->Post->last();
        $categories = $this->Category->all();
        $this->render('posts.index', compact('posts', 'categories'));
    }

    public function category()
    {
        $user = Session::getInstance()->read('auth');
        if ($user != null) {
            $category = $this->Category->find($_GET['id']);

            if ($category === false) {
                $this->notFound();
            }

            $posts = $this->Post->lastByCategory($_GET['id']);
            $categories = $this->Category->all();
            $this->render('users.category', compact('posts', 'categories', 'category'));
        } else {
            $category = $this->Category->find($_GET['id']);

            if ($category === false) {
                $this->notFound();
            }

            $posts = $this->Post->lastByCategory($_GET['id']);
            $categories = $this->Category->all();
            $this->render('posts.category', compact('posts', 'categories', 'category'));
        }


    }

    public function show()
    {
        $user = Session::getInstance()->read('auth');
        $articles = $this->Post->findWithCategory($_GET['id']);
        $comments = $this->Comment->validCommentsByPosts($_GET['id']);
        if (!empty($comments)) {
            $comments_by_id = [];

            foreach ($comments as $comment) {
                $comments_by_id[$comment->id] = $comment;
            }
            foreach ($comments as $k => $comment) {
                if ($comment->parent_id != 0) {
                    $comments_by_id[$comment->parent_id]->children[] = $comment;
                    unset($comments[$k]);
                }
            }
            if ($user != null) {
                $adminName = explode('_', $user->username);
                if ($adminName[0] == 'Admin' && $user->id == 1) {

                    if ((isset($_POST['content'])) && (!empty($_POST['content']))) {
                        $this->comment();
                        $form = new BootstrapForm($_POST);
                        $this->render('admin.posts.show', compact('articles', 'comments', 'form'));
                    } else {
                        $form = new BootstrapForm($_POST);
                        $this->render('admin.posts.show', compact('articles', 'comments', 'form'));
                    }
                } else {
                    if ((isset($_POST['content'])) && (!empty($_POST['content']))) {
                        $this->comment();
                        $form = new BootstrapForm($_POST);
                        $this->render('users.show', compact('articles', 'comments', 'form'));
                    } else {
                        $form = new BootstrapForm($_POST);
                        $this->render('users.show', compact('articles', 'comments', 'form'));
                    }

                }
            }
            $this->render('posts.show', compact('articles', 'comments'));
        } elseif ($user != null) {
            $adminName = explode('_', $user->username);
            if ($adminName[0] == 'Admin' && $user->id == 1) {
                $this->comment();
                $form = new BootstrapForm($_POST);
                $this->render('admin.posts.show', compact('articles', 'form'));
            } else {
                $this->comment();
                $form = new BootstrapForm($_POST);
                $this->render('users.show', compact('articles', 'form'));
            }

        } else {
            $this->render('posts.show', compact('articles'));
        }
    }


    private
    function comment()
    {
        if ((isset($_POST['content'])) && (!empty($_POST['content']))) {
            $user = Session::getInstance()->read('auth');
            $this->Comment->submitComment($_POST['content'], $user->username, $_GET['id']);
            Session::getInstance()->setFlash('success', 'Votre commentaire est en attente de validation');
            App::getInstance()->redirect('posts.show&id=' . $_GET['id']);
        }
    }

    public function delete()
    {
        $this->Post->delete($_GET['comment_id']);
        Session::getInstance()->setFlash('success', "Le commentaire a bien été supprimer");
        App::getInstance()->redirect('posts.show&id=' . $_GET['posts_id']);
    }
}