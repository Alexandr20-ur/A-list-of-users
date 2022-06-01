<?php
namespace app\core;
class Validation
{
    public $data;
    public $errors = [];

    public function __construct($post_data)
    {
        $this->fields = $_POST;
        $this->data = $post_data;
    }

    public function validateForm()
    {
        $this->validateName();
        $this->validateSurname();
        $this->validateEmail();
        $this->validateTelephone();
        $this->validateAge();
        return $this->errors;
    }

    public function validateName(){
        $val = $this->data['name'];
        if (empty($val)) {
            $this->addError('name', 'данные не переданы');
        } else {
            if(is_numeric($val) == true) {
                $this->addError('name', 'данные не корректны');
            }
        }
    }
    public function validateSurname(){
        $val = $this->data['surname'];
        if(empty($val)) {
            $this->addError('surname' ,'данные не переданы');
        } else {
            if(is_numeric($val) == true){
                $this->addError('surname', 'данные не корректны');
            }
        }
    }

    public function validateTelephone(){
        $val = $this->data['telephone'];
        if(!$val) {
            $this->addError('telephone','телефон не указан');
        } else {
            if(is_numeric($val) == false) {
                $this->addError('telephone', 'данные не корректны');
            }
        }
    }

    public function validateAge(){
        $val = $this->data['age'];
        if(empty($val)) {
            $this->addError('age','данные не указаны');
        } else {
            if(is_numeric($val) == false) {
                $this->addError('age', 'данные не корректны');
            }
        }
    }

    public function validateEmail(){
        $val = $this->data['email'];
        if(empty($val)) {
            $this->addError('email','email не указан');
        } else {
            if(!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                $this->addError('email', 'email не корректный');
            }
        }
    }



    public function addError($key, $val)
    {
        $this->errors[$key] = $val;
    }
}