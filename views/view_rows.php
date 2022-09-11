<?php /** @var $this \app\views\View */
use app\models\config\Input;

$values =$this->get('values');
$errors = $this->get('error');

foreach ($this->get('fields') as $key => $field):
    $tag = new Input( $field, $values[$key] ?? null); ?>
    <h3><?=$field['nameRow'];?></h3>
    <p><?= $tag->open();?></p>
    <?php if (!empty($errors[$field['name']])): ?>
        <div class='error'><?= $errors[$field['name']] ;?></div>
    <?php endif; ?>
<?php endforeach;?>
     <br>
<div class='error'><?=$this->get('sending')?></div>