<?php /** @var $this \app\views\View */ ?>

<style>
   table {
       border-style: solid;
       border-color: black;
   }

</style>
<?php
$data = $this->get('data');
$ipage = (int) $this->get('ipage');
$number = $this->get('number');
?>
<form action="" method="get">
    <input type="hidden" name="page" value="<?=$ipage?>">
    Дата: <input name="date" type="text" value="<?=$data['date'] ?? null;?>">
    Код ошибки: <input name="code" type="text" value="<?=$data['code'] ?? null;?>">
    <button type="submit">Поиск</button>
</form>
<form action="log?page=1" method="post">
    <button type="submit">сбросить</button>
    Кол-во записей: <?=$number?>
</form>
<table>
    <tr>
        <td>№</td>
        <td>Дата</td>
        <td>Код ошибки</td>
        <td>Файл ошибки</td>
        <td>Линия ошибки</td>
        <td>Путь ошибки</td>
        <td>Sql-запрос</td>
    </tr>
    <?php foreach ($this->get('read') as  $elem):?>
    <tr>
        <td><?=$elem['number'] ?? null;?></td>
        <td><?=$elem['date'] ?? null;?></td>
        <td><?=$elem['code'] ?? null;?></td>
        <td><?=$elem['file'] ?? null;?></td>
        <td><?=$elem['line'] ?? null;?></td>
        <td>
            <?php if (!empty($elem['trace'])) {?>
            <?php foreach ($elem['trace'] as $result):?>
            <?=$result ?? null?>
            <?php endforeach;?>
            <?php }else ?>
        </td>
        <td><?=$elem['sql'] ?? null;?></td>
    </tr>
    <?php endforeach;?>
</table>
<?php $this->navigation->display();?>

