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
class ListController implements Action
{
    public $fields;
    public $page;
    public $data;

    public function __construct($page, $data) {
        $this->page = $page;
        $this->data = $data;
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

    private function viewRowsMain() {
        $view = (new FormRow($this->fields, $this->data))->viewRows('/views/view_rows_list.php');
        $view->assign('edit', 'edit');
        $view->assign('btnEdit', 'Изменить');
        $view->assign('del', 'delete');
        $view->assign('btnDel', 'Удалить');
        $view->assign('buy', 'Goods_add');
        $view->assign('add','add');
        $view->assign('product', 'product');
        $view->assign('show', 'просмотр');
        $view->assign('fields', $this->fields);
        $view->assign('data', $this->data);

        $records = 5;

        $count = $this->numberOfUsers();
        $view->assign('count', $count);
        $pages = ceil($count / $records);
        $view->assign('users', $this->getUsers($records, $pages));
        $url = 'list?';
        $view->navigation = $this->pageNavigation($pages, $this->page, $this->data, $url);
        return $view;
    }

    private function getUsers($records, $pages): array {
        $database = Database::getInstance();
        $fields = [];
        $result = [];
        if($this->page < $pages) {
            $offset = ($this->page >= 2)
                ? ' OFFSET ' . $records * ($this->page - 1)
                : '';
        }
        foreach ($this->fields as $key => $elem) {
            $fields[] = 'u.' . $key;
            if (empty($this->data[$key])) continue;

            $value = $this->data[$key];
            $data = $this->prepareData($elem, $value);
            if ($data) $result[] = 'u.'.$key.' = ' . $data;
        }
        $where = $result ? ' WHERE ' . implode(' AND ', $result) : '';

        $sql = 'select u.id, '. implode(', ', $fields) . ',
            COUNT(c.userID) as count  
            FROM users as u
            LEFT JOIN coods as c ON u.id = c.userID '
            . $where .
            ' GROUP BY u.id 
            LIMIT 5'. $offset;
        return $database->result($sql);
    }

    private function numberOfUsers () {
        $database = Database::getInstance();
        $result = [];
        foreach ($this->fields as $key => $elem) {
            if (empty($this->data[$key])) continue;

            $value = $this->data[$key];
            $data = $this->prepareData($elem, $value);
            if ($data) $result[] = $key.' = ' . $data;
        }
        $where = $result ? ' WHERE ' . implode(' AND ', $result) : '';
        $sql = 'SELECT COUNT(users.id) FROM users ' . $where;
        return $database->column($sql);
    }

    private function prepareData(array $field, $value) {
        switch ($field['dataType']) {
            case 'int': return (int) $value;
            default: return "'" . Database::getInstance()->getConnection()->real_escape_string($value) . "'";
        }
    }

    private function pageNavigation($pages, $ipage, $data, $url) {
        return (new Pagination($pages, $ipage, $data, $url))->run();
    }
}
