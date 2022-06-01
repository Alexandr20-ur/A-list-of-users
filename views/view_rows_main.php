<?php /** @var $this \app\views\View */

$fields = $this->get('fields');
$users = $this->get('users');

?>
<table>
    <tr>
        <?php foreach ($fields as $key => $field):
            foreach ($field as $elem):?>
            <?php endforeach;?>
            <th><?=$field['nameRow'];?></th>
        <?php endforeach;?>
    </tr>
    <?php foreach($users as  $user):?>
        <tr>
            <td><?=$user['name'];?></td>
            <td><?=$user['surname'];?></td>
            <td><?=$user['age'];?></td>
            <td><?=$user['telephone'];?></td>
            <td><?=$user['Email'];?></td>
            <td><a href="<?= $this->get('edit') ?>"><button><?= $this->get('btnEdit') ?></button></a></td>
            <td><a href="<?= $this->get('del') ?>"><button><?= $this->get('btnDel') ?></button></a></td>
        </tr>
    <?php endforeach;?>
</table>
<br>
