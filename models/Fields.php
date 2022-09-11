<?php
namespace app\models;

class Fields  implements IFieldsRepository {

    function get() {
        return [
            'name' => [
                'type' => 'text',
                'name' => 'name',
                'nameRow' => 'Имя',
                'dataType' => 'string'
            ],
            'surname' => [
                'type' => 'text',
                'name' => 'surname',
                'nameRow' => 'Фамилия',
                'dataType' => 'string'
            ],
            'age' => [
                'type' => 'text',
                'name' => 'age',
                'nameRow' => 'Возраст',
                'dataType' => 'int'
            ],
            'telephone' => [
                'type' => 'text',
                'name' => 'telephone',
                'nameRow' => 'Телефон',
                'dataType' => 'phone'
            ],
            'email' => [
                'type' => 'email',
                'name' => 'email',
                'nameRow' => 'email',
                'dataType' => 'email'
            ]
        ];
    }
}