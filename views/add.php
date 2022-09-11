<?php /** @var $this \app\views\View */ ?>
<?php /** @var $this \app\controllers\AddController */?>

<title>Добавление</title>
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
<form action="add" method="post" id="form" >
    <?php $this->filingRows->display();?>
    <input type="submit" value="Добавить" name="submit">
</form>
</body>

