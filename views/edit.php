<?php /** @var $this \app\views\View */ ?>
<?php /** @var $this \app\controllers\EditController */?>
<title>Изменение</title>
<style>
    form {
        text-align: center;
        line-height: 20px;
    }
</style>
<body>
<form action="edit" method="post" id="form" >
    <?php $this->filingRows->display();?>
    <input type="submit" value="Изменить" name="submit">
</form>
</body>
