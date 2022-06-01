<?php

include 'core/Validation.php';
//ini_set('display_errors', 1);
//include 'models/config/Connection.php';
//include 'views/main_view.php';
function debag($string)
{
    echo '<pre>';
    var_dump($string);
    echo '</pre>';
}

use app\Router;
spl_autoload_register(function ($class) {
    $class = str_replace('app','' , $class);
    $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $class . '.php';
    include $path;
});

$path = $_SERVER['REQUEST_URI'];
$path = str_replace('/', '', $path);

$handler = Router::getHandler($path);
$v = $handler->run();
$v->display();