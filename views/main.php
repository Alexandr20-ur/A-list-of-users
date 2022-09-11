<?php /** @var $this \app\views\View */ ?>

<title>Список</title>
<body>
    <?php $this->filingRows->display();?>
    <a href="<?= $this->get('url') ?>"><button><?= $this->get('btnName') ?></button></a>
    <a href="list?"><button>Сбросить</button></a>
</body>


