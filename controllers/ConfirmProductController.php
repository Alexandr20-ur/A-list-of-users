<?php /** @var $this \app\views\View */

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

class ConfirmProductController implements Action
{
    private array $fields;
    private $data;
    private $message;
    private $userId;

    public function __construct($data) {
        $this->fields = (new FieldsBuy())->get();
        $this->data = $data;
    }

    public function run(): View {
        $view = new View();
        $view->setTpl(PATH.'\views\view_goods_errors.php');

        if(empty($this->data['userID'])) {
            $errors[] = $this->getMessage()->get(MessageErrors::ERROR_ID);
            $view->errors = $this->viewErrors($errors);
            return $view;
        }
        $this->userId = abs((int) $this->data['userID']);
        if (!$this->checkUserId()) {
            $errors[] = $this->getMessage()->get(MessageErrors::ERROR_ID);
            $view->errors = $this->viewErrors($errors);
            return $view;
        }
        $view->assign('id', $this->userId);
        $view->form = $this->form();
        $count = $this->numberOfGoods();
        if($count >= AddProductController::LIMIT) {
            $view->form->assign('count', $count);
            $errors = [];
            $errors[] = $this->getMessage()->get(MessageErrors::COUNT_ERORR);
            $view->errors = $this->viewErrors($errors);
            return $view;
        }
        $valid = new Validation($this->data, $this->fields);
        $errors = $valid->check();
        $view->form->assign('errors', $errors);
        if ($errors) return $view;

//        $fields = null;
//        foreach(array_keys($this->fields) as $elem) {
//            $fields = !empty($this->data[$elem]);
//        }
//
//        if($fields === false) return $view;

        $prepare = (new PrepareValues())->get($this->fields, $this->data);
        if ($this->addRecord($prepare)) {
            $i = 1;
            $view->form->assign('i', $i);
            $message = $this->getMessage()->get(MessageErrors::ADD_SUCCESS);
            $view->form->assign('message', $message);
        } else {
            $errors = $this->getMessage()->get(MessageErrors::ADD_ERROR);
            $view->errors = $this->viewErrors($errors);
        }

        return $view;
    }

    private function form() {
        return (new FormRow($this->fields, $this->data))
            ->viewRows('\views\view_goods.php');
    }

    private function addRecord($values) {
        $database = Database::getInstance();
        $result = [];
        foreach ($this->fields as $key => $elem) {
            if (empty($this->data[$key])) continue;

            $value = $values[$key];
            switch ($elem['dataType']) {
                case 'int': $result[$key] = (int)$value;
                    break;
                default: $result[$key] = "'" . $database->getConnection()->real_escape_string($value) . "'";
                    break;
            }
        }
        $sql = 'INSERT INTO `coods` (' . implode(',', array_keys($result)) . ') VALUES (' . implode(',', $result) . ')';
        return $database->insert($sql);
    }

    private function viewErrors($errors) {
        return (new Errors($errors))->view();
    }

    private function numberOfGoods () {
        $database = Database::getInstance();
        $sql = 'SELECT COUNT(coods.userID) FROM `coods` WHERE coods.userID = '.$this->userId;
        return $database->column($sql);
    }

    private function getMessage() {
        if ($this->message === null) {
            $this->message = new MessageErrors();
        }
        return $this->message;
    }

    private function checkUserId() {
        $sql = 'SELECT id FROM users WHERE id = ' . $this->userId;
        return (bool) Database::getInstance()->row($sql);
    }

}