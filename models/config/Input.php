<?php
/** @var $this \app\controllers\AddController */

namespace app\models\config;
use app\views\View;
class Input
{
    private $name; //Свойство для хранения имени тега
    private $field = [];
    private $value;


    public function __construct($name, $field, $value)
    {
        $this->name = $name;
        $this->field = $field;
        $this->value = $value;

    }

    //Выводим открывающую часть тега
    public function open() {
        return '<input type="'. $this->field['type'] .'" value="'.$this->value.'" name="'. $this->field['name'] .'">';
    }




}