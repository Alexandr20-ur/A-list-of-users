<?php
namespace app\views;


use app\models\MessageErrors;

class Errors {
    private array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    function view(): View
    {
        $view = new View();
        $view->setTpl(dirname(__DIR__) . '/views/view_error_message.php');
        $view->assign('errors', $this->errors);
        return $view;
    }
}