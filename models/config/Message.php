<?php

namespace app\models\config;

use app\core\Database;
use app\models\MessageErrors;
use app\views\Errors;

class Message
{

    public function count($view, $count) {
        $error = new Message();
        $error->message($view,MessageErrors::COUNT_ERORR);
        return $view->form->assign('count', $count);
    }

    public function message($view, $message) {
        $errors = [];
        $errors[] = (new MessageErrors())->get($message);
        return $view->errors = $this->viewErrors($errors);
    }


    private function viewErrors($errors) {
        return (new Errors($errors))->view();
    }

    public function numberOfCoods ($id) {
        $database = Database::getInstance();
        $sql = 'SELECT COUNT(coods.userID) FROM `coods` WHERE coods.userID = '.$id;
        return $database->count($sql);
    }
}