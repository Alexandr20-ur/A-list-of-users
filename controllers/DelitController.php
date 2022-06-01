<?php
namespace app\controllers;

use app\Action;
use app\models\Fields;
use app\views\View;

class DelitController implements Action
{

    public function run() {
        $this->fields = (new Fields())->get();
        $this->values = $_POST;

        $view = new View();
        $view->setTpl(dirname(__DIR__) . '/views/delete.php');
        return $view;
    }
}