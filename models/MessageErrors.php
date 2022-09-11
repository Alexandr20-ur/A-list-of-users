<?php
namespace app\models;

class MessageErrors {
    const SEND_ERROR = 'send_error';
    const LOAD_ERROR = 'load_error';
    const CHANGE_ERROR = 'change_error';
    const ADD_ERROR = 'add_error';
    const DEL_ERROR = 'del_error';
    const GOODS_ERROR = 'goods_error';
    const COUNT_ERORR = 'count_error';
    const ADD_SUCCESS = 'add_success';
    const ERROR_ID = 'error_id';
    const ERROR_URL = 'error_url';

    private $errors = [
        self::SEND_ERROR => 'произошла ошибка при отправке',
        self::LOAD_ERROR => 'произошла ошибка при загрузке',
        self::CHANGE_ERROR => 'произошла ошибка при изменении данных',
        self::ADD_ERROR => 'произошла ошибка при добавлении',
        self::DEL_ERROR => 'Произошла ошибка при удалении',
        self::GOODS_ERROR => 'Произошла ошибка при покупке',
        self::COUNT_ERORR => 'Вы больше не можете купить товар',
        self::ADD_SUCCESS => 'Добавление прошло успешно',
        self::ERROR_ID => 'Не правильный ID',
        self::ERROR_URL => 'Неправильный url',

    ];

    function get($key): string {
        return $this->errors[$key];
    }
}