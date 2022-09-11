<?php /** @var $this \app\views\View */ ?>
<?php
use app\models\config\Input;
use app\models\config\TagForm;
$errors = $this->get('errors');
$values = $this->get('values');
$count = $this->get('count');
$i = $this->get('i');
$message = $this->get('messages');
$fields = $this->get('fields');
?>

<form action="" id="form">
<?php
foreach ($fields as $key => $field):
    $tag = new Input('input', $field, $values[$key] ?? null);
    $tagForm = new TagForm($field);?>
    <?= $tagForm->open()?>
    <p><?= $tag->open();?></p>
    <?php if (!empty($errors[$field['name']])): ?>
        <div class='error'><?= $errors[$field['name']] ;?></div>
    <?php endif; ?>
<?php endforeach;?>

<?php if (!$count):?>
    <button type="submit" name="submit" value="купить" id="submit">Купить</button>
<?php endif;?>
</form>
<?php if($i):?>
    <a href="list"><button name="down">Назад</button></a>
    <p><?=$message?></p>
<?php endif;?>


