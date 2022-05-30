<?php /** @var $this \app\views\View */

use app\models\config\Input;

$values =$this->get('values');
$errors = $this->get('errors');

foreach ($this->get('fields') as $key => $field):
    $tag = new Input('input', $field, $values[$key] ?? null); ?>
    <?= "<h3>" . $field['nameRow'] . "</h3>";?>
    <?= $tag->open() . '</br>' ?>
    <?php if (!empty($errors[$key])): ?>
        <?="<div class='error'>".$errors[$key]."</div>";?>
    <?php endif; ?>
<?php endforeach;?>
<?="</br>"?>

