<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Db;

class MainController extends Controller
{
    public function indexAction()
    {
        $db = new Db;

        $params = [
            "id" => 3
        ];
        $data = $db->row("SELECT `name` FROM `users` WHERE `id` = :id", $params);
        var_dump($data);

        $this->view->render("Главная страница");
    }

}