<?php /** @var $this \app\views\View */ ?>
<?php
$page = $this->get('page'); //тек. страница
$pages = $this->get('pages'); // кол-во страниц
$data = $this->get('data'); // кол-во записей
$url = $this->get('url');

$next = $page + 1;
$back = $page - 1;

?>
<?php if($page > 1): $data['page'] = $back;?>
    <a href="<?=$url.http_build_query($data)?>">Назад</a>
<?php endif;?>

<?php for($i = 1; $i <= $pages; $i++):
    $data['page'] = $i;?>
    <a href="<?=$url.http_build_query($data)?>"><?=$i?></a>
<?php endfor;?>

<?php if($page < $pages):
    $data['page'] = $next;?>
    <a href="<?=$url.http_build_query($data)?>">Вперед</a>
<?php endif;?>