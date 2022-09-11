<?php
namespace app\models\config;

class TagForm
{
    private $fields;
    private $name;

    public function __construct($name, $fields) {
        $this->fields = $fields;
        $this->name = $name;
    }

    public function open() {
        return ($this->fields['type'] != 'hidden') ? '<'.$this->name.'>'.$this->fields['nameRow'].'</'.$this->name.'>' : '';
    }
}