<?php

namespace App\Controller;

use App;
use Core\mailer\Mailer;
use Core\Session\Session;

/**
 * Class PostsController
 * @package App\Controller
 */
class PostsController extends AppController
{

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Post');
        $this->loadModel('Category');
        $this->loadModel('Subscription');

    }

    /**
     * Allows users to subscribe to a category
     */
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
                if ($this->Subscription->isAlreadySubscribed($user, $_POST['category_id'])) {
                    Session::getInstance()->setFlash('info', "Vous vous êtes déjà abonné à cette catégorie");
                    App::getInstance()->redirect('posts.category&id=' . $_POST['category_id']);
                } else {
                $this->Subscription->subscribe($user->id, $_POST['category_id']);
                $mailer = new Mailer();                
                $mailer->sendMail([
                    'email' => $user->email,
                    'subject' => 'Nouvel abonnement',
                    'message' => "Vous vous êtes abonné à la catégorie <em><strong>" . $_POST['category_name'] . "</strong></em> en provenance du site web A simple dev's blog, vous recevrez désormais toutes les actualités concernant cette catégorie. À tout moment vous pourrez vous désabonner en retournant sur le site et en vous rendant sur la page de la catégorie souhaitée.",
                ]);
                }
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

    /**
     * Show index page
     */
    public function index()
    {
        $posts = $this->Post->last();
        $categories = $this->Category->all();
        $this->render('posts.index', compact('posts', 'categories'));
    }

    /**
     * Show post with rights of user
     */
    public function show()
    {
        $user = Session::getInstance()->read('auth');
        $articles = $this->Post->findWithCategory($_GET['id']);
        $comments = $this->sortComments();
        if ($comments) {
            if ($user != null) {
                $this->showComments('users.show', $articles, $comments);
            }
            $this->showComments('posts.show', $articles, $comments, false);
        } elseif ($user != null) {
            $this->showComments('users.show', $articles, null);
        } else {
            $this->showComments('posts.show', $articles, null, false);
        }
    }


    /**
     *
     */
    public function delete()
    {
        $this->Post->deleteComments($_GET['comment_id']);
        Session::getInstance()->setFlash('success', "Le commentaire a bien été supprimé");
        App::getInstance()->redirect('posts.show&id=' . $_GET['posts_id']);
    }
}