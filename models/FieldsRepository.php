<?php
namespace app\models;

class FieldsRepository implements IFieldsRepository {

    function get() {
        return [
            'name' => [
                'type' => 'text',
                'name' => 'name',
                'form' => 'form',
                'nameRow' => 'Имя'

            ],
            'surname' => [
                'type' => 'text',
                'name' => 'surname',
                'form' => 'form',
                'nameRow' => 'Фамилия'
            ],
            'age' => [
                'type' => 'text',
                'name' => 'age',
                'form' => 'form',
                'nameRow' => 'Возраст'
            ],
            'telephone' => [
                'type' => 'text',
                'name' => 'telephone',
                'form' => 'form',
                'nameRow' => 'Телефон'
            ],
            'email' => [
                'type' => 'email',
                'name' => 'email',
                'form' => 'form',
                'nameRow' => 'email'
            ]
        ];
    }
}