<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;

/**
 * Class PostsController
 * @package App\Controller\Admin
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
        $this->loadModel('Subscription');
    }

    /**
     * Add a post
     */
    public function add()
    {

        if (!empty($_POST)) {
            $this->loadModel('Category');
            $category_name = $this->Category->categoryNameFromId($_POST['categories_id']);
            $users = $this->Subscription->whoIsSubscribed($_POST['categories_id']);
            if ($users) {
                $this->Subscription->alertUser($users, $category_name);
            }

            $result = $this->Post->create([
                'titre' => $_POST['titre'],
                'contenu' => $_POST['contenu'],
                'categories_id' => $_POST['categories_id'],
                'date_update' => date('Y-m-d H:i:s')
            ]);
            if ($result) {
                return $this->index();
            }
            if ($result) {
                ?>
                <div class="alert alert-success">L'article a bien été ajouté</div>
                <?php
            }
        }

        $this->loadModel('Category');
        $categories = $this->Category->extract('id', 'titre');
        $form = new BootstrapForm($_POST);
        $this->render('admin.posts.add', compact('categories', 'form'));
    }

    /**
     * Show the index page of Admin Center
     */
    public
    function index()
    {
        $posts = $this->Post->all();
        $this->render('admin.posts.index', compact('posts'));
    }

    /**
     * Edit a post
     */
    public
    function edit()
    {
        if (!empty($_POST)) {
            $result = $this->Post->update($_GET['id'], [
                'titre' => $_POST['titre'],
                'contenu' => $_POST['contenu'],
                'categories_id' => $_POST['categories_id'],
                'date_update' => date('Y-m-d H:i:s')
            ]);
            if ($result) {
                return $this->index();
            }
        }
        $post = $this->Post->find($_GET['id']);
        $this->loadModel('Category');
        $categories = $this->Category->extract('id', 'titre');
        $form = new BootstrapForm($post);
        $this->render('admin.posts.edit', compact('categories', 'form'));
    }

    /**
     * Delete a post
     */
    public
    function delete()
    {
        if (!empty($_POST)) {
            $result = $this->Post->delete($_POST['id']);
            return $this->index();
        }
    }
}
