<?php /** @var $this \app\views\View */

$fields = $this->get('fields');
$users = $this->get('users');
$numberOfUsers = $this->get('numberOfUsers');
$addProduct = $this->get('buy');
$numberOfCoods = $this->get('numberCoods');
$values = $this->get('values');
$add = $this->get('add');
?>



<form action="" method="post" name="my">
    <script>
        function rename(){
            var field = document.getElementById("input");
            var e = document.getElementById("options");
            var strUser = e.options[e.selectedIndex].value;
            field.setAttribute("name", strUser);
        }
    </script>
    <select id="options" onchange="rename();">
        <option value="">Не выбрано</option>
        <option value="surname">Фамилия</option>
        <option value="name">Имя</option>
    </select>
    <input name="list" value="" type="text" id="input">
    Возраст: <input type="text" name="age" value="<?=$values['age'] ?? null ?>">
  Телефон: <input type="text" name="telephone" value="<?=$values['telephone'] ?? null ?>">
  Email:   <input type="text" name="email" value="<?=$values['email'] ?? null ?>">
    <button type="submit">Поиск</button>
</form>
<p>Кол-во записей: <?=$this->get('count')?></p>
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
            <td style="display: none"><?=$user['id'];?></td>
            <td><?=$user['name'];?></td>
            <td><?=$user['surname'];?></td>
            <td><?=$user['age'];?></td>
            <td><?=$user['telephone'];?></td>
            <td><?=$user['email'];?></td>
            <td><a href="<?=$addProduct?>?userID=<?=$user['id']?>" target="_blank"><button><?=($user['count'] != 0) ? $user['count'] : $add?></button></a></td>
            <td><a href="<?=$this->get('product')?>?id=<?=$user['id']?>" target="_blank"><button><?=$this->get('show')?></button></a></td>
            <td><a href="<?=$this->get('edit')?>?id=<?=$user['id']?>"><button><?=$this->get('btnEdit')?></button></a></td>
            <td><a href="<?= $this->get('del')?>?id=<?=$user['id']?>"><button><?=$this->get('btnDel')?></button></a></td>
        </tr>
    <?php endforeach;?>
</table>
<?php $this->navigation->display();?>
<br>

