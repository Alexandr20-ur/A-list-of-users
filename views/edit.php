<?php /** @var $this \app\views\View */ ?>
<?php /** @var $this \app\controllers\EditController */?>
<?php
$id = $this->get('id');
?>
<title>Изменение</title>
<style>
    form {
        text-align: center;
        line-height: 20px;
    }
    div {
        text-align: center;
    }
</style>
<body>
    <?php $this->errorRows->display();?>
<form action="" method="post">
    <?php $this->filingRows->display();?>
    <input type="submit" value="Изменить" name="submit">
</form>
</body>
