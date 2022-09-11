<?php
namespace app\models\config;

class Textarea
{

    private array $field = [];
    private $id = [];


    public function __construct($field, $id = null)
    {
        $this->field = $field;
        $this->id = $id;
    }

    //Выводим открывающую часть тега
    public function open() {
        return '<textarea name="'.$this->field['name'].'" cols="30" rows="10" id="'.$this->id['name'].'"></textarea>';

    }


}