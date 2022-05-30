<?php /** @var $this \app\views\View */ ?>
<?php
$fields = $this->get('fields');
$post = $this->get('post');
$users = $this->get('users');
?>
<table>
   <?php foreach ($fields as $key => $field):
    foreach ($field as $elem){
    };
       echo '<pre>';
       print_r($field);
       echo '</pre>';?>

    <td></td>
    <?php endforeach;?>
    <?php foreach($users as  $user):?>
    <?php
        echo '<pre>';
        print_r($users);
        echo '</pre>';
        ?>
    <?php endforeach;?>

</table>

<a href="<?= $this->get('url') ?>"><button><?= $this->get('btnName') ?></button></a>
<br>
<br>
<a href="<?= $this->get('edit') ?>"><button><?= $this->get('btnEdit') ?></button></a>