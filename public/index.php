<?php

use Core\Session\Session;

define('ROOT', dirname(__DIR__));

require ROOT . '/app/App.php';
App::load();

if (isset($_GET['p'])) {
    $page = $_GET['p'];
} else {
    $page = 'posts.index';
}


$page = explode('.', $page);
if ($page[0] == 'admin') {
    $auth = Session::getInstance()->read('auth');
    $authName = explode('_', $auth->username);
    if ($authName[0] === 'Admin') {
        $controller = '\App\Controller\Admin\\' . ucfirst($page[1]) . 'Controller';
        $action = $page[2];
    } else {
        Session::getInstance()->setFlash('danger', "Vous n'êtes pas authorisé à vous rendre sur cette page");
        App::getInstance()->redirect('posts.index');
    }
} else {
    $controller = '\App\Controller\\' . ucfirst($page[0]) . 'Controller';
    $action = $page[1];
}
$controller = new $controller;
$controller->$action();