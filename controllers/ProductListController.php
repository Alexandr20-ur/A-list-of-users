<?php

namespace app\controllers;

use app\Action;
use app\core\Database;
use app\models\config\Debag;
use app\models\FieldsBuy;
use app\views\View;
class ProductList implements Action
{
    private array $fields;
    private $id;

    public function __construct($id) {
        $this->fields = (new FieldsBuy())->get();
        $this->id = $id;
    }

    public function run() {
       $view = new View();
       $view->setTpl(PATH . '\views\list.php');
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
        $sql = 'SELECT ' . implode(', ', array_keys($this->fields)) . ' FROM `coods`  WHERE userID = ' . $this->id;
        return Database::getInstance()->result($sql);
    }
}