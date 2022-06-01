<?php /** @var $this \app\views\View */ ?>
<?php
$fields = $this->get('fields');
$post = $this->get('post');
$users = $this->get('users');
?>
<title>Главная</title>
<body>
    <?php $this->filingRows->display();?>
    <a href="<?= $this->get('url') ?>"><button><?= $this->get('btnName') ?></button></a>
</body>


