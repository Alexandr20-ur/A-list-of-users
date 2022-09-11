<?php
namespace app\controllers;

use app\Action;
use app\core\Database;
use app\models\config\Debag;
use app\models\Fields;
use app\models\MessageErrors;
use app\views\Errors;
use app\views\View;
use app\models\FormRow;
use JetBrains\PhpStorm\Pure;

include 'models/config/pathFiles.php';
class DelitController implements Action
{
    private $id;
    private $fields;
    private $value;

    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public function run() {
        $view = new View();
        $view->setTpl(PATH . '\views\delete.php');
        $view->delete = $this->viewDelete();
        return $view;
    }

    public function viewDelete() {
        $view =  (new FormRow($this->getFields(), $this->getUser()))->viewRows('/views/view_rows_delete.php');
        $view->assign('main', 'main');
        $view->assign('btn', 'нет');
        $view->assign('delete', 'delete');
        $view->assign('btnYes', 'да');
        $view->assign('users', $this->getUser());
        $view->assign('id', $this->id);
        Debag::p($this->value);
        if (!empty($this->value)){
            $this->deleteRecord();
            header('Location: main');
        } else {
            $messageErrors = new MessageErrors();
            $errors = [];
            $errors[] = $messageErrors->get(MessageErrors::DEL_ERROR);
            $view->errorRows = $this->viewErrors($errors);
        }
        return $view;
    }

    private function getUser() {
        $database = Database::getInstance();
        $sql = 'SELECT ' . implode(',', array_keys($this->getFields())) . ' FROM `users`  WHERE id = ' . $this->id;
        return $database->displayByID($sql);
    }

    public function deleteRecord(){
        $database = Database::getInstance();
        $sql = 'DELETE FROM `users` WHERE `users`.`id`=' . $this->id . ' LIMIT 1';
        return $database->delete($sql);
    }
    private function getFields(): array
    {
        if ($this->fields === null) {
            $this->fields = (new Fields())->get();
        }
        return $this->fields;
    }

    private function viewErrors($errors): View {
        return (new Errors($errors))->view();
    }
}
