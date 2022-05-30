<?php
namespace app\models;

use app\views\View;

class FormRow {
    private $fields, $values;

    /**
     * @param $fields
     * @param $values
     */
    public function __construct($fields, $values)
    {
        $this->fields = $fields;
        $this->values = $values;
    }

    function viewRows($path) {
        $view = new View();
        $view->setTpl(dirname(__DIR__) . $path);
        $view->assign('fields', $this->fields);
        $view->assign('values', $this->values);
        return $view;
    }
}