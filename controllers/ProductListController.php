<?php

namespace app\controllers;

use app\Action;
use app\core\Database;
use app\models\config\Debag;
use app\models\FieldsBuy;
use app\models\MessageErrors;
use app\views\Errors;
use app\views\View;
class ProductListController implements Action
{
    private array $fields;
    private $data;
    private $message;
    private $userId;

    public function __construct($data) {
        $this->fields = (new FieldsBuy())->get();
        $this->data = $data;
    }

    public function run() {
       $view = new View();
       $view->setTpl(PATH . '\views\list.php');

        if (empty($this->data['userID'])) {
            $errors[] = $this->getMessage()->get(MessageErrors::ERROR_URL);
            $view->errors = $this->viewErrors($errors);
            return $view;
        }

        $this->userId = abs((int) $this->data['userID']);
        if (!$this->checkUserId($this->userId)) {
            $errors[] = $this->getMessage()->get(MessageErrors::ERROR_ID);
            $view->errors = $this->viewErrors($errors);
            return $view;
        }
       $view->goods = $this->viewGoods();
       return $view;
    }

    private function viewGoods() {
        $view = new View();
        $view->setTpl(PATH.'\views\view_list.php');
        $view->assign('products', $this->getProducts());
        $view->assign('fields', $this->fields);
        return $view;
    }

    private function getProducts() {
        $sql = 'SELECT ' . implode(', ', array_keys($this->fields)) . ' FROM `coods`  WHERE userID = ' . $this->data['userID'];
        return Database::getInstance()->result($sql);
    }

    private function viewErrors($errors) {
        return (new Errors($errors))->view();
    }

    private function getMessage() {
        if ($this->message === null) {
            $this->message = new MessageErrors();
        }
        return $this->message;
    }

    private function checkUserId($id) {
        $sql = 'SELECT id FROM users WHERE id = '.$id;
        return (bool) Database::getInstance()->row($sql);
    }
}