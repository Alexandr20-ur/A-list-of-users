<?php /** @var $this \app\views\View */ ?>
<?php
use app\models\config\Input;
use app\models\config\TagForm;
$errors = $this->get('errors');
$values = $this->get('values');
$count = $this->get('count');
$i = $this->get('i');
$message = $this->get('message');
$fields = $this->get('fields');
?>

<form action="" id="form">
<?php
foreach ($fields as $key => $field):
    $tag = new Input( $field, $values[$key] ?? null);
    $tagForm = new TagForm('h3' ,$field);?>
    <?= $tagForm->open()?>
    <p><?= $tag->open();?></p>
    <?php if (!empty($errors[$field['name']])): ?>
        <div class='error'><?= $errors[$field['name']] ;?></div>
    <?php endif; ?>
<?php endforeach;?>

<?php if (!$count && !$i):?>
    <button type="submit" name="submit" value="купить" id="submit">Купить</button>
<?php endif;?>
</form>
<?php if($i):?>
    <p><?=$message?></p>
<?php endif;?>


