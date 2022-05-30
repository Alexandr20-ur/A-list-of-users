<?php
namespace app\controllers;

use app\Action;
use app\core\Validation;
use app\models\Fields;
use app\models\FormRow;
use app\views\View;

class EditController implements Action
{

    private $fields;
    private $values;


    public function run() {

        $this->fields = (new Fields())->get();
        $this->values = $_POST;

        $view = new View();
        $view->setTpl(dirname(__DIR__) . '/views/edit.php');
        $view->filingRows = $this->viewRows();
        return $view;
    }

    private function viewRows() {
        $view = (new FormRow($this->fields, $this->values)) ->viewRows('/views/view_rows_edit.php');
        if(isset($_POST['submit'])) {
            $valid = new Validation($this->values);
            $errors = $valid->validateForm();
            $view->assign('errors', $errors);
        }
        return $view;
    }

}
