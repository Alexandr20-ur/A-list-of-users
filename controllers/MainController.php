<?php
namespace app\controllers;

use app\Action;
use app\core\Database;
use app\models\Fields;
use app\models\FormRow;
use app\views\View;

class MainController implements Action
{
    public $fields;
    public $post;

    public function run()
    {
        $this->fields = (new Fields())->get();
        $this->post = $_POST;

        $view = new View();
        $view->setTpl(dirname(__DIR__) . '/views/main.php');
        $view->assign('url', 'add');
        $view->assign('btnName', 'Добавить');
        $view->filingRows = $this->viewRowsMain();
        return $view;
    }

    public function viewRowsMain(){
        $view = (new FormRow($this->fields, $this->post))->viewRows('/views/view_rows_main.php');
        $view->assign('edit', 'edit');
        $view->assign('btnEdit', 'Изменить');
        $view->assign('del', 'delete');
        $view->assign('btnDel', 'Удалить');
        $view->assign('fields', $this->fields);
        $view->assign('post', $this->post);
        $view->assign('users', $this->dbDisplay());
        return $view;
    }

    public function dbDisplay(){
    $database = Database::getInstance();
    return $database->display();

    }
}