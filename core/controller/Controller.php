<?php

namespace Core\Controller;

use Core\Session\Session;

class Controller
{

    protected $viewPath;
    protected $template;

    protected function render($view, $variables = [])
    {
        if(Session::getInstance()->read('auth')) {
            ob_start();
            extract($variables);
            require($this->viewPath . str_replace('.', '/', $view) . '.php');
            $content = ob_get_clean();
            require($this->viewPath . 'template/' . 'users-default.php');
            exit();
        } else {
            ob_start();
            extract($variables);
            require($this->viewPath . str_replace('.', '/', $view) . '.php');
            $content = ob_get_clean();
            require($this->viewPath . 'template/' . $this->template . '.php');
            exit();
        }

    }

    protected function forbidden()
    {
        header('HTTP/1.0 403 Forbidden');
        die('Access Denied');
    }

    protected function notFound()
    {
        header('HHTP/1.0 404 Not Found');
        die('Page introuvable');
    }
}