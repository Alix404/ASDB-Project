<?php


namespace App\Controller;

use App;
use Core\Controller\Controller;

class AppController extends Controller
{
    protected $template = 'default';

    public function __construct()
    {
        $this->viewPath = ROOT . '/app/Views/';
    }

    protected function loadModel($modelName)
    {
        $this->$modelName = App::getInstance()->getTable($modelName);
    }
}