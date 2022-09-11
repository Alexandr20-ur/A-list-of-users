<?php
namespace app\controllers;


use app\Action;
use app\views\View;

class ErrorPageController implements Action
{

    public function run() {
        $view = new View();
        $view->setTpl(PATH.'\views\error_page.php');
        $view->error = $this->page();
        return $view;
    }

    private function page () {
        $view = new View();
        $view->setTpl(PATH.'\views\view_error_page.php');
        return $view;
    }
}