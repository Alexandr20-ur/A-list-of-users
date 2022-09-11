<?php /** @var $this \app\views\View */

namespace app\controllers;

use app\Action;
use app\core\Database;
use app\core\Validation;
use app\models\config\Debag;
use app\models\FieldsBuy;
use app\models\MessageErrors;
use app\models\PrepareValues;
use app\views\Errors;
use app\views\View;
use JetBrains\PhpStorm\Pure;

include 'models/config/pathFiles.php';
class ConfirmBuyController implements Action
{
    private array $fields;
    private $value;

    public function __construct($value) {

        $this->fields = (new FieldsBuy())->get();
        $this->value = $value;
    }

    public function run(): View {
        $view = new View();
        $view->setTpl(PATH.'\views\view_buy_errors.php');
        $view->show = $this->show();
        if (!isset($this->value['submit'])) return $view;

        $valid = new Validation($this->value, $this->fields);
        $errors = $valid->check();
        $view->show->assign('errors', $errors);
        $prepare = (new PrepareValues())->get($this->fields, $this->value);
        if($errors) return  $view;

        if ($this->addRecord($prepare)) header('Location: list');

        $messageErrors = new MessageErrors();
        $errors = [];
        $errors[] = $messageErrors->get(MessageErrors::BUY_ERORR);
        $view->errors = $this->viewErrors($errors);
        return $view;
    }

    public function show(): View {
        $view = new View();
        $view->setTpl(PATH.'\views\view_buy.php');
        $view->assign('inputData', array_slice($this->fields, 0,2));
        $view->assign('textareaData', array_slice($this->fields, 2));
        $view->assign('value', $this->value);
        return $view;
    }

    public function addRecord($values) {
        $database = Database::getInstance();
        $result = [];
        foreach ($this->fields as $nameEn => $field) {
            if (!isset($values[$nameEn])) continue;

            $value = $values[$nameEn];
            $result[$nameEn] = match ($field['dataType']) {
                'int' => (int)$value,
                default => "'" . $database->getConnection()->real_escape_string($value) . "'",
            };
        }
        $sql = 'INSERT INTO `coods` (' . implode(',', array_keys($result)) . ') VALUES (' . implode(',', $result) . ')';
        return $database->insert($sql);
    }

    private function viewErrors($errors) {
        return (new Errors($errors))->view();
    }

}