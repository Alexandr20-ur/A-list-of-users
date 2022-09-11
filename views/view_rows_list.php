<?php /** @var $this \app\views\View */

use app\models\config\Input;

$fields = $this->get('fields');
$users = $this->get('users');
$numberOfUsers = $this->get('numberOfUsers');
$addProduct = $this->get('buy');
$numberOfCoods = $this->get('numberCoods');
$data = $this->get('data');
$add = $this->get('add');
$result = null;
$value = '';
if(!empty($data['options'])) {
    $value = $data[$data['options']];
    $result = $data['options'];
}
?>
<form action="" method="GET" name="my" id="my">
    <script>
        function rename(){
            var field = document.getElementById('input');
            var e = document.getElementById('options');
            var strUser = e.options[e.selectedIndex].value;
            field.setAttribute('name', strUser);
        }
    </script>
    <select id="options" onchange="rename()" onsubmit="submitForm()" name="options" >
        <option name="0" value="" <?=(empty($result)) ? 'selected' : null?> >Не выбрано</option>
        <option name="surname" value="surname" <?=($result == 'surname') ? 'selected' : null?>>Фамилия</option>
        <option name="name" value="name" <?=($result == 'name') ? 'selected' : null?>>Имя</option>
    </select>
    <input name="<?=$data['options'] ?? null ?>" value="<?=$value ?? null ?>" type="text" id="input">
    Возраст: <input type="text" name="age" value="<?=$data['age'] ?? null ?>">
    Телефон: <input type="text" name="telephone" value="<?=$data['telephone'] ?? null ?>">
    Email:   <input type="text" name="email" value="<?=$data['email'] ?? null ?>">
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
            <td><a href="<?=$this->get('product')?>?userID=<?=$user['id']?>" target="_blank"><button><?=$this->get('show')?></button></a></td>
            <td><a href="<?=$this->get('edit')?>?id=<?=$user['id']?>"><button><?=$this->get('btnEdit')?></button></a></td>
            <td><a href="<?= $this->get('del')?>?id=<?=$user['id']?>"><button><?=$this->get('btnDel')?></button></a></td>
        </tr>
    <?php endforeach;?>
</table>
<?php $this->navigation->display();?>
<br>


