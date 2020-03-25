<?php

require_once "application/lib/Dev.php";
use application\core\Router;

spl_autoload_register(function($class) {
    require $class.'.php';
});

session_start();

$router = new Router();
$router->run();