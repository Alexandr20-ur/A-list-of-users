<?php /** @var $this \app\views\View */?>
<?php
$fields = $this->get('fields');
$user = $this->get('users');
$id = $this->get('id');
?>
<table>
    <tr>
        <?php foreach ($fields as $key => $field):
            foreach ($field as $elem):?>
            <?php endforeach;?>
            <th><?=$field['nameRow'];?></th>
        <?php endforeach;?>
    </tr>
        <tr>
            <td style="display: none"><?=$user['id'];?></td>
            <td><?=$user['name'];?></td>
            <td><?=$user['surname'];?></td>
            <td><?=$user['age'];?></td>
            <td><?=$user['telephone'];?></td>
            <td><?=$user['email'];?></td>
            <td><a href="<?= $this->get('list') ?>"><button><?= $this->get('btn') ?></button></a></td>
            <form action="del" method="post">
                <input type="hidden" name="id" value="<?=$id?>">
                <td><button name="delete" type="submit"><?= $this->get('btnYes') ?></button></td>
            </form>
        </tr>
</table>
<br>
