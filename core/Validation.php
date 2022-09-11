<?php
namespace app\core;
use app\models\config\Debag;
use app\views\View;

class Validation
{
    public $data;
    public $errors = [];
    private $fields;

    public function __construct($data, $fields) {
        $this->data = $data;
        $this->fields = $fields;
    }

    function check() {
        $errors = [];
        $values = $this->data;
        foreach ($this->fields as $nameEn => $field) {
            if (!isset($values[$nameEn])) continue;

            $value = $values[$nameEn];
            switch ($field['dataType']) {
                case 'int':
                case 'phone':
                    $v = (int) $value;
                    if(!$v) $errors[$field['name']] = 'данные не указаны';
                    if ($v <= -1) {
                        $errors[$field['name']] = 'данные должны быть положительными';
                    }
                    break;
                case 'string';
                case 'email';
                    $v = $value;
                    if(!$v) $errors[$field['name']] = 'Введите данные';
                    if(!is_numeric($v) == false) $errors[$field['name']] = 'данные не корректны';
                    break;
            }


        }
       return $errors;
    }
}