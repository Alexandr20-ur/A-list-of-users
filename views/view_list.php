<?php /** @var $this \app\views\View */?>
<?php
$product = $this->get('products');
$fields = $this->get('fields');
?>
<style>
    table {
        border-style: solid;
        border-color: black;
        margin-left: 40%;
        margin-top: 15%;
    }

</style>
<table>
    <tr>
        <?php foreach ($fields as $key => $field):
            foreach ($field as $elem):?>
            <?php endforeach;?>
            <th><?=$field['nameRow'];?></th>
        <?php endforeach;?>
    </tr>
    <?php foreach ($product as $elem):?>
        <tr>
            <td><?=$elem['userID'];?></td>
            <td><?=$elem['name'];?></td>
            <td><?=$elem['description'];?></td>
        </tr>
    <?php endforeach;?>
</table>


