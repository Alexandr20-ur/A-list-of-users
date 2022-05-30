<?php
namespace app\controllers;
use app\Action;
use app\core\Database;
use app\models\Fields;
use app\models\config\ViewRow;
use app\models\FieldsRepository;
use app\models\FormRow;
use app\usecases\GetFieldsUseCase;
use app\views\View;
use app\core\Validation;
class AddController implements  Action
{
    private $fields;
    private $values;

    public function run() {
        $this->fields = (new Fields())->get();
        $this->values = $_POST;

        $view = new View();
        $view->setTpl(dirname(__DIR__) . '/views/add.php');
        $view->filingRows = $this->viewRows();
        return $view;
    }

    private function viewRows() {
        $view = (new FormRow($this->fields, $this->values))->viewRows('/views/view_rows.php');
        if (isset($_POST['submit'])) {
            $valid = new Validation($this->values);
            $errors = $valid->validateForm();
            $view->assign('errors', $errors);
            if (!$errors){
                foreach ($this->fields as $nameEn => $field) {
                    $result[$nameEn] = $this->values[$nameEn];
                }
                $this->dbInsert($result);
            }
        }
        return $view;
    }

    private function dbInsert($post_data){
        $column = [];
        $values = [];
        $database =  Database::getInstance();
        foreach ($post_data as $keyTable => $value) {
            $column[] = $keyTable;
            $values[] = "'" . $value . "'";
        }
        $insert ='INSERT INTO `users` (' . implode(', ', $column) . ') VALUES (' . implode(', ', $values) . ')';
        $database->insert($insert);
    }
}