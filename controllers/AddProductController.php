<?php

namespace app\controllers;

use app\Action;
use app\core\Database;
use app\core\Validation;
use app\models\config\Debag;
use app\models\FieldsBuy;
use app\models\FormRow;
use app\models\MessageErrors;
use app\models\PrepareValues;
use app\views\Errors;
use app\views\View;
use JetBrains\PhpStorm\Pure;

include 'models/config/pathFiles.php';
class BuyController implements Action
{
    private $value;
    private $id;
    private array $fields;

    public function __construct($value, $id) {
        $this->value = $value;
        $this->id = $id;
        $this->fields = (new FieldsBuy())->get();
    }

    public function run(): View {
        $view = new View();
        $view->setTpl(PATH.'\views\buy.php');
        $view->viewForm = $this->buyForm();
        $count = $this->numberOfCoods();
        if($count >= 10) {
            $view->viewForm->assign('count', $count);
            $messageErrors = new MessageErrors();
            $errors = [];
            $errors[] = $messageErrors->get(MessageErrors::COUNT_ERORR);
            $view->errorRows = $this->viewErrors($errors);
            return $view;
        }
        return $view;
    }


    public function buyForm(): View {
        $view = new View();
        $view->setTpl(PATH.'\views\view_buy.php');
        $view->assign('value', $this->value);
        $view->assign('inputData', array_slice($this->fields, 0,2));
        $view->assign('textareaData', array_slice($this->fields, 2));
        $view->assign('id', $this->id);
        return $view;
    }



    private function viewErrors($errors) {
        return (new Errors($errors))->view();
    }

    private function numberOfCoods () {
        $database = Database::getInstance();
        $sql = 'SELECT COUNT(coods.userID) FROM `coods` WHERE coods.userID = '.$this->id;
        return $database->count($sql);
    }

}