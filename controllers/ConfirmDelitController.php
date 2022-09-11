<?php
namespace app\controllers;

use app\Action;
use app\core\Database;
use app\models\config\Debag;
use app\models\Fields;
use app\views\View;
use app\models\FormRow;

class ConfirmDelitController implements Action
{
    private $id;
    private $fields;

    public function __construct($id) {
        $this->id = $id;
    }

    public function run() {
        $view = new View();
        $view->setTpl(PATH . '\views\delete.php');
        $view->delete = $this->viewDelete();
        return $view;
    }

    private function viewDelete() {
        $view =  (new FormRow($this->getFields(), $this->getUser()))
            ->viewRows('/views/view_rows_delete.php');
        $view->assign('list', 'list');
        $view->assign('btn', 'нет');
        $view->assign('delete', 'delete');
        $view->assign('btnYes', 'да');
        $view->assign('users', $this->getUser());
        $view->assign('id', $this->id);
        return $view;
    }

    private function getUser() {
        $database = Database::getInstance();
        $sql = 'SELECT ' . implode(',', array_keys($this->getFields())) . ' FROM `users`  WHERE id = ' . $this->id;
        return $database->row($sql);
    }

    private function getFields() {
        if ($this->fields === null) {
            $this->fields = (new Fields())->get();
        }
        return $this->fields;
    }


}
