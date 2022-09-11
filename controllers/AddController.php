<?php
namespace app\controllers;
use app\Action;
use app\core\Database;
use app\models\config\Debag;
use app\models\Fields;
use app\models\config\ViewRow;
use app\models\FormRow;
use app\models\MessageErrors;
use app\models\PrepareValues;
use app\views\Errors;
use app\views\View;
use app\core\Validation;

class AddController implements Action
{
    private $fields;
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function run() {
        $view = new View();
        $view->setTpl(PATH. '\views\add.php');
        $this->fields = (new Fields())->get();
        $prepare = (new PrepareValues())->get($this->fields, $this->data);
        $view->filingRows = $this->viewRows($prepare);
        //Валидация данных
        if (!isset($this->data['submit'])) return $view;

        $valid = new Validation($this->data, $this->fields);
        $errors = $valid->check();
        $view->filingRows->assign('error', $errors);
        if ($errors) return $view;

        if (!$this->save($this->fields, $prepare)) {
            $messageErrors = new MessageErrors();
            $errors = [];
            $errors[] = $messageErrors->get(MessageErrors::ADD_ERROR);
            $errors[] = $messageErrors->get(MessageErrors::SEND_ERROR);
            $view->errorRows = $this->viewErrors($errors);
        } else {
            header("Location: list");
        }

        return $view;
    }

    private function viewRows($prepare) {
        $result = array_filter($prepare, function ($v) {
            return ($v);
        });
        return (new FormRow($this->fields, $result))
            ->viewRows('/views/view_rows.php');
    }

    private function viewErrors($errors) {
        return (new Errors($errors))->view();
    }

    //функция выполнения записи данных в бд
    private function save($fields, $data) {
        $database = Database::getInstance();
        $result = [];
        foreach ($fields as $key => $elem) {
            if (empty($data[$key])) continue;

            $value = $data[$key];
            switch ($elem['dataType']) {
                case 'int':
                    $result[$key] = (int)$value;
                    break;
                default:
                    $result[$key] = "'" . $database->getConnection()->real_escape_string($value) . "'";
                    break;
            }
        }
        $sql = "INSERT INTO `users` (" . implode(', ', array_keys($result)) . ") VALUES (" . implode(', ', $result) . ")";
        return $database->insert($sql);
    }
}


