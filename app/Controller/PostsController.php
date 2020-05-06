<?php

namespace App\Controller;
class PostsController extends AppController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Post');
        $this->loadModel('Category');

    }

    public function index()
    {
        $posts = $this->Post->last();
        $categories = $this->Category->all();
        $this->render('posts.index', compact('posts', 'categories'));
    }

    public function category()
    {

        $category = $this->Category->find($_GET['id']);

        if ($category === false) {
            $this->notFound();
        }

        $articles = $this->Post->lastByCategory($_GET['id']);
        $categories = $this->Category->all();
        $this->render('posts.category', compact('articles', 'categories', 'category'));


    }

    public function show()
    {
        $articles = $this->Post->findWithCategory($_GET['id']);
        $this->render('posts.show', compact('articles'));
    }
}