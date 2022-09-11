<?php

namespace app\models;

class PrepareValues
{
    public function get(array $fields, array $values) {
        $r = [];
        foreach ($fields as $nameEn => $field) {
            if (!isset($values[$nameEn])) continue;

            $value = $values[$nameEn];
            switch ($field['dataType']) {
                case 'int';
                case 'phone';
                    $value = (int)$value;

                    $r[$field['name']] = $value ;
                    break;
                case 'string';
                case 'email';
                    $r[$field['name']] = trim($value);
                    break;
            }
        }
        return $r;
    }
}