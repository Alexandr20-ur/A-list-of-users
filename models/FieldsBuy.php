<?php

namespace app\models;

class FieldsBuy implements IFieldsRepository
{
    public function get() {
        return [
            'userID' => [
                'type' => 'hidden',
                'name' => 'userID',
                'nameRow' => 'id товара',
                'dataType' => 'int'
            ],
            'name' => [
                'type' => 'text',
                'name' => 'name',
                'nameRow' => 'Название товара',
                'dataType' => 'string'
            ],
            'description' => [
                'type' => 'textarea',
                'name' => 'description',
                'nameRow' => 'Описание',
                'dataType' => 'string'
            ]
        ];
    }

}