<?php

namespace application\core;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        $arr = require "application/config/routes.php";
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
    }

    public function add($route, $params)
    {
        $route = "#^{$route}$#";
        $this->routes[$route] = $params;
    }

    public function match()
    {
        $url = trim($_SERVER["REQUEST_URI"], "/");
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run()
    {
        if ($this->match() == true) {
            $controller = ucfirst($this->params['controller']);
            $path = "application/controllers/{$controller}Controller.php";
            if (class_exists($path)) {
                $action = "$this->params['action']Action";
                if (method_exists($path, $action)) {
                    //
                } else {
                    echo "Не найден Экшн";
                }
            } else {
                echo "Не найден контроллер {$path}";
            }
        } else {
            echo "Маршрут не найден";
        }
//        echo "start";
    }
}