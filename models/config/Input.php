<?php
/** @var $this \app\controllers\AddController */

namespace app\models\config;
use app\views\View;
class Input
{
    private $field = [];
    private $value;


    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    //Выводим открывающую часть тега
    public function open() {
        if($this->field['type'] === 'textarea'){
            return '<textarea name="'.$this->field['name'].'" cols="30" rows="10" id="'.$this->field['name'].'"></textarea>';
        } else {
            return '<input type="'. $this->field['type'] .'" value="'.$this->value.'" name="'. $this->field['name'] .'" id="'.$this->field['name'].'">';
        }
    }




}