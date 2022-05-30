<?php /** @var $this \app\views\View */

use app\models\config\Input;

$values =$this->get('values');
$errors = $this->get('errors');

foreach ($this->get('fields') as $key => $field):
    $value = $values[$key] ?? '';
    $tag = new Input('input', $field, $value); ?>
    <?= "<h3>" . $field['nameRow'] . "</h3>";?>
    <?= $tag->open() . '</br>' ?>
<?php endforeach;?>
<?="</br>"?>

<?php

