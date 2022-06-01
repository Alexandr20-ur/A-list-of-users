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
use Exception;

ini_set('display_errors', 1);
class AddController implements Action
{
    private $fields;
    private $values;

    private function prepareValues(array $fields, array $values) {
        $prepareResult = [];
        foreach ($fields as $nameEn => $field) {
            if (!isset($values[$nameEn])) continue;

            $value = $values[$nameEn];
            switch ($field['dataType']) {
                case 'int':
                    $prepareResult[$field['name']] = (int) $value;
                    break;
                case 'string';
                case 'email';
                case 'phone';
                    $prepareResult[$field['name']] = trim($value);
                    break;
            }
        }
        return $prepareResult;
    }

    public function run() {
        $this->fields = (new Fields())->get();
        $this->values = $_POST;

        $view = new View();
        $view->setTpl(dirname(__DIR__) . '/views/add.php');
        $view->filingRows = $this->viewRows();


        if (isset($_POST['submit'])) {
            $valid = new Validation($this->values);
            $this->prepareValues($this->fields, $this->values);
            $errors = $valid->validateForm();
            $view->filingRows->assign('errors', $errors);
            if (!$errors) {
                if(!$this->save($this->fields, $this->values)){
                    $view->assign('errorMessage', 'Произошла ошибка');
                } else {
                    header("Location: main");
                }
            }
        }
        return $view;
    }

    private function viewRows() {
        return (new FormRow($this->fields, $this->prepareValues($this->fields, $this->values)))->viewRows('/views/view_rows.php');
    }

    private function save($fields, $values) {
        $column = [];
        $database = Database::getInstance();
        $result = [];
        foreach ($fields as $nameEn => $field) {
            $column[] = $nameEn;
            if (!isset($values[$nameEn])) continue;
            $value = $values[$nameEn];
            switch ($field['dataType']) {
                case 'int':
                    $result[] = (int) $value;
                    break;
                case 'string';
                case 'email';
                case 'phone';
                    $result[] = "'".$database->getConnection()->real_escape_string($value)."'";
                    break;
            }
        }

        $sql = "INSERT INTO `users` (".implode(',',$column).") VALUES (".implode(',', $result).")";
        return $database->insert($sql);
    }
}


function debag($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}
