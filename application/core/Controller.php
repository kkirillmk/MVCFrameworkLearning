<?php

namespace application\core;

use application\core\View;

abstract class Controller
{
    public $route;
    public $view;
    public $acl;

    public function __construct($route)
    {
        $this->route = $route;
        if (!$this->checkAcl()) {
            View::errorCode(403);
        }
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name)
    {
        $model = ucfirst($name);
        $path = 'application'.DS.'models'.DS.$model;
        if (class_exists($path)) {
            return new $path();
        }
    }

    public function checkAcl()
    {
        $path = "application/acl/{$this->route['controller']}.php";
        if (file_exists($path)) {
            $this->acl = require $path;
        }
        if ($this->isAcl("all")) {
            return true;
        } elseif (isset($_SESSION['authorize']['id']) and $this->isAcl("authorize")) {
            return true;
        } elseif (!isset($_SESSION['authorize']['id']) and $this->isAcl("guest")) {
            return true;
        } elseif (isset($_SESSION['admin']) and $this->isAcl("admin")) {
            return true;
        }
        return false;
    }

    public function isAcl($key)
    {
        if (!empty($this->acl)) {
            return in_array($this->route['action'], $this->acl[$key]);
        }
        return false;
    }
}