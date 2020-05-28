<?php

namespace App\Controller;

use App;
use Core\HTML\BootstrapForm;
use Core\Mail\Mail;
use Core\Session\Session;

class PostsController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Post');
        $this->loadModel('Category');
        $this->loadModel('Subscription');

    }

    public function category()
    {
        $user = Session::getInstance()->read('auth');
        if ($user != null) {
            $category = $this->Category->find($_GET['id']);

            if ($category === false) {
                $this->notFound();
            }
            if ((!empty($_POST['category_id'])) && (isset($_POST['category_id']))) {

                $user = Session::getInstance()->read('auth');
                $this->Subscription->subscribe($user->id, $_POST['category_id']);
                Mail::sendMail
                (
                    $user->email,
                    'Nouvelle abonnement',
                    "Vous vous êtes abonnés à la catégorie <em><strong>" . $_POST['category_name'] . "</strong></em> en provenance du site web A simple dev's blog, vous recevrez désormais toutes les actualités concernant cette catégorie. À tout moment vous pourrez vous désabonnez en retournant sur le site et en vous rendant sur la page de la catégorie souhaitée.",
                    'posts.show',
                    "Retourner à l'accueil"
                );
                $posts = $this->Post->lastByCategory($_GET['id']);
                $categories = $this->Category->all();
                $this->index();
            } else {
                $posts = $this->Post->lastByCategory($_GET['id']);
                $categories = $this->Category->all();
                $this->render('users.subscription', compact('posts', 'categories', 'category'));
            }
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

    public function index()
    {
        $posts = $this->Post->last();
        $categories = $this->Category->all();
        $this->render('posts.index', compact('posts', 'categories'));
    }

    public function show()
    {
        $user = Session::getInstance()->read('auth');
        $articles = $this->Post->findWithCategory($_GET['id']);
        $comments = $this->sortComments();
        if ($comments) {
            if ($user != null) {
                $adminName = explode('_', $user->username);
                if ($adminName[0] == 'Admin' && $user->id == 1) {
                    $this->showComments('admin.posts.show', $articles, $comments);
                } else {
                    $this->showComments('users.show', $articles, $comments);

                }
            }
            $this->showComments('posts.show', $articles, $comments, false);
        } elseif
        ($user != null) {
            $adminName = explode('_', $user->username);
            if ($adminName[0] == 'Admin' && $user->id == 1) {
                $this->showComments('admin.posts.show', $articles, null);
            } else {
                $this->showComments('users.show', $articles, null);
            }

        } else {
            $this->showComments('posts.show', $articles, null, false);
        }
    }


    public
    function delete()
    {
        $this->Post->delete($_GET['comment_id']);
        Session::getInstance()->setFlash('success', "Le commentaire a bien été supprimer");
        App::getInstance()->redirect('posts.show&id=' . $_GET['posts_id']);
    }
}