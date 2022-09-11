<?php
namespace app\controllers;

use app\Action;
use app\core\Database;
use app\core\Validation;
use app\models\config\Debag;
use app\models\Fields;
use app\models\FormRow;
use app\models\MessageErrors;
use app\models\PrepareValues;
use app\views\Errors;
use app\views\View;
class EditController implements Action
{

    private array $fields;
    private $data;

    public function __construct($data) {
        $this->fields = (new Fields())->get();
        $this->data = $data;
    }

    public function run() {
        $view = new View();
        $view->setTpl(PATH . '\views\edit.php');
        $view->assign('id', $this->data['id']);
        $view->filingRows = $this->viewRows();
        if (!isset($this->data['submit'])) return $view;

        $valid = new Validation($this->data, $this->fields);
        $errors = $valid->check();
        $view->filingRows->assign('error', $errors);
        if ($errors) return $view;
        $result = (new PrepareValues())
            ->get($this->fields, $this->data);
        $values = array_diff($result, $this->GetUser());

        if(empty($values) || !$this->update($values)){
            $messageErrors = new MessageErrors();
            $errors = [];
            $errors[] = $messageErrors->get(MessageErrors::CHANGE_ERROR);
            $view->errorRows = $this->viewErrors($errors);
            return $view;
        } else {
            header('Location: list');
        }
        return $view;
    }

    private function viewRows() {
        return (new FormRow($this->fields, $this->getUser()))
            ->viewRows('/views/view_rows.php');
    }

    private function getUser() {
        $database = Database::getInstance();
        $sql = 'SELECT ' . implode(', ', array_keys($this->fields)) . ' FROM `users`  WHERE id = ' . $this->data['id'];
        return $database->row($sql);
    }

    private function update($values) {
        $database = Database::getInstance();;
        $result = [];
        foreach ($this->fields as $key => $elem) {
            if (empty($values[$key])) continue;

            $value = $values[$key];
            switch ($elem['dataType']) {
                case 'int': $result[$key] = $key.' = '.(int)$value;
                    break;
                default: $result[$key] = $key.' = '."'" . $database->getConnection()->real_escape_string($value) . "'";
                    break;
            }
        }
        $sql = 'UPDATE `users` SET ' . implode(', ', $result) . ' WHERE `users`.`id`=' . $this->data['id'] . ' LIMIT 1';
        return $database->update($sql);
    }


    private function viewErrors($errors): View {
        return (new Errors($errors))->view();
    }


}