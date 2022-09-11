<?php
namespace app\controllers;

use app\Action;
use app\core\Database;
use app\models\config\Debag;
use app\models\MessageErrors;
use app\views\Errors;
use app\views\View;
class DeleteController implements Action
{
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    public function run() {
        if ($this->deleteRecord()) header('Location: list');
        $view = new View();
        $view->setTpl(PATH.'\views\delete.php');
        $errors = [];
        $errors[] = (new MessageErrors())->get(MessageErrors::CHANGE_ERROR);
        $view->errorRows = $this->viewErrors($errors);
        return $view;
    }

    private function deleteRecord() {
        $database = Database::getInstance();
        $sql = 'DELETE FROM `users` WHERE `users`.`id`=' . $this->id . ' LIMIT 1';
        return $database->delete($sql);
    }

    private function viewErrors($errors): View {
        return (new Errors($errors))->view();
    }

}