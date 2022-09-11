<?php
namespace app\controllers;

use app\Action;
use app\core\Database;
use app\models\config\Debag;
use app\models\config\Pagination;
use app\models\Fields;
use app\models\FieldsBuy;
use app\models\FormRow;
use app\models\PrepareValues;
use app\views\View;
include 'models/config/pathFiles.php';
class MainController implements Action
{
    public $fields;
    public $page;
    public $values;

    public function __construct($page, $values) {
        $this->page = $page;
        $this->values = $values;
    }

    public function run() {
        $this->fields = (new Fields())->get();
        $view = new View();
        $view->setTpl(PATH.'\views\main.php');
        $view->assign('url', 'add');
        $view->assign('btnName', 'Добавить');
        $view->filingRows = $this->viewRowsMain();
        return $view;
    }

    private function viewRowsMain(){
        $view = (new FormRow($this->fields, $this->values))->viewRows('/views/view_rows_main.php');
        $view->assign('edit', 'edit');
        $view->assign('btnEdit', 'Изменить');
        $view->assign('del', 'delete');
        $view->assign('btnDel', 'Удалить');
        $view->assign('buy', 'Goods_add');
        $view->assign('add','add');
        $view->assign('product', 'product');
        $view->assign('show', 'просмотр');
        $view->assign('fields', $this->fields);
        $view->assign('values', $this->values);

        $records = 5;

        $count = $this->numberOfUsers();
        $view->assign('count', $count);
        $view->assign('users', $this->dbResult($records));
        $pages = ceil($count / $records);
        $url = 'list?';
        $view->navigation = $this->pageNavigation($pages, $this->page, $this->values, $url);
        return $view;
    }

    private function dbResult($records) {
        $database = Database::getInstance();
        $user = [];
        $result = [];
        $offset = null;
        if ($this->page >= 2) { $offset  = ' OFFSET '.($records  * ($this->page - 1));}
        foreach ($this->fields as $key => $elem) {
            $user[] = 'u.' . $key;
            if (empty($this->value[$key])) continue;

            $value = $this->value[$key];
            switch ($elem['dataType']) {
                case 'int':
                    $result[] = 'u.'.$key.' = '.(int)$value;
                    break;
                default:
                    $result[] = 'u.'.$key.' = '."'" . $database->getConnection()->real_escape_string($value) . "'";
                    break;
            }
        }

        $where = $result ? ' WHERE ' : null;

        $sql = 'SELECT u.id, '. implode(', ', $user) . ',
            COUNT(c.userID) as count  
            FROM users as u
            LEFT JOIN coods as c
            ON u.id = c.userID '
            . $where . implode(' AND ', $result).
            ' GROUP BY u.id 
            LIMIT 5'. $offset;
        return $database->result($sql);
    }

    private function numberOfUsers () {
        $database = Database::getInstance();
        $result = [];
        foreach ($this->fields as $key => $elem) {
            if (empty($this->value[$key])) continue;

            $value = $this->value[$key];
            switch ($elem['dataType']) {
                case 'int':
                    $result[] = $key.' = '.(int)$value;
                    break;
                default:
                    $result[] = $key.' = '."'" . $database->getConnection()->real_escape_string($value) . "'";
                    break;
            }
        }
        $where = $result ? ' WHERE ' : null;

        $sql = 'SELECT COUNT(users.id) FROM users ' . $where . implode(', ', $result);
        return $database->count($sql);
    }

    private function pageNavigation($pages, $ipage, $data, $url) {
        return (new Pagination($pages, $ipage, $data, $url))->run();
    }
}
