<?php

namespace app\controllers;

use app\Action;
use app\core\Database;
use app\models\config\Debag;
use app\models\FieldsBuy;
use app\models\FormRow;
use app\models\MessageErrors;
use app\Router;
use app\views\Errors;
use app\views\View;

class AddProductController implements Action
{
    const LIMIT = 10;

    private $data;
    private array $fields;
    private $message;

    private $userId;

    public function __construct($data) {
        $this->data = $data;
        $this->fields = (new FieldsBuy())->get();
    }

    public function run(): View {
        $view = new View();
        $view->setTpl(PATH.'\views\add_goods.php');
        $view->form = $this->form();

        //Проверки
        if (empty($this->data['userID'])) {
            $i = 1;
            $view->form->assign('i', $i);
            $errors[] = $this->getMessage()->get(MessageErrors::ERROR_URL);
            $view->errors = $this->viewErrors($errors);
            return $view;
        }

        $this->userId = abs((int) $this->data['userID']);
        if (!$this->checkUserId()) {
            $i = 1;
            $view->form->assign('i', $i);
            $errors[] = $this->getMessage()->get(MessageErrors::ERROR_ID);
            $view->errors = $this->viewErrors($errors);
            return $view;
        }

        // Добавляем
        $view->form->assign('id', $this->userId);
        $count = $this->numberOfCoods();
        //Проверка по кол-ву записи
        if ($count >= self::LIMIT) {
            $view->form->assign('count', $count);
            $errors = [];
            $errors[] = $this->getMessage()->get(MessageErrors::COUNT_ERORR);
            $view->errors = $this->viewErrors($errors);
        }

        return $view;
    }

    private function form() {
        return (new FormRow($this->fields,$this->data))
            ->viewRows('\views\view_goods.php');
    }

    private function viewErrors($errors) {
        return (new Errors($errors))->view();
    }

    private function numberOfCoods() {
        $database = Database::getInstance();
        $sql = 'SELECT COUNT(coods.userID) FROM `coods` WHERE coods.userID = ' . $this->userId;
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