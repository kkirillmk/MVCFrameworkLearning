<?php

require_once "application/lib/Dev.php";
use application\core\Router;

spl_autoload_register(function($class) {
    if (file_exists("{$class}.php")) {
        require "{$class}.php";
    }
});

session_start();

$router = new Router();
$router->run();