<?php

use Core\Auth\DBAuth;
use Core\Config;
use Core\Database\MysqlDatabase;

class App
{
    private static $_instance;
    private static $db_auth;
    public $title = "A simple dev's blog";
    private $db_instance;

    public static function load()
    {
        session_start();
        require "../vendor/autoload.php";
    }

    public static function getAuth()
    {
        if (is_null(self::$db_auth)) {
            self::$db_auth = new DBAuth(App::getInstance()->getDb());
        }
        return self::$db_auth;
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public function getTable($name)
    {
        $class_name = '\\App\\Model\\' . ucfirst($name) . 'Model';
        return new $class_name($this->getDb());
    }

    public function getDb()
    {
        $config = Config::getInstance(ROOT . '/config/config.php');

        if (is_null($this->db_instance)) {
            $this->db_instance = new MysqlDatabase($config->get('db_name'), $config->get('db_host'), $config->get('db_user'), $config->get('db_pass'));
        }
        return $this->db_instance;
    }

    public function redirect($location) {
        header("Location: index.php?p=$location");
        exit();
    }
}