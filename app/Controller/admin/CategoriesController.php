<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;

/**
 * Class CategoriesController
 * @package App\Controller\Admin
 */
class CategoriesController extends AppController
{
    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Category');
    }

    /**
     * Add a category
     */
    public function add()
    {
        if (!empty($_POST)) {
            $this->Category->create([
                'titre' => $_POST['titre']
            ]);
            return $this->index();
        }
        $form = new BootstrapForm($_POST);
        $this->render('admin.categories.add', compact('form'));
    }

    /**
     * Show the index page of Admin center
     */
    public function index()
    {
        $items = $this->Category->all();
        $this->render('admin.categories.index', compact('items'));
    }

    /**
     * Edit a category
     */
    public function edit()
    {
        if (!empty($_POST)) {
            $this->Category->update($_GET['id'], [
                'titre' => $_POST['titre']
            ]);
            return $this->index();
        }
        $category = $this->Category->find($_GET['id']);
        $form = new BootstrapForm($category);
        $this->render('admin.categories.edit', compact('form'));
    }

    /**
     * Delete a category
     */
    public function delete()
    {
        if (!empty($_POST)) {
            $this->Category->delete($_POST['id']);
            return $this->index();
        }

    }
}