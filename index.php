<?php /** @var $this \app\views\View */
include 'models/config/pathFiles.php';

include 'core/Validation.php';
use app\core\DatabaseExp;
use app\Router;


spl_autoload_register(function ($class) {
    $class = str_replace('app', '', $class);
    $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $class . '.php';
    include $path;
});

$path = $_SERVER['REQUEST_URI'];
$path = str_replace('/', '', $path);

try {
    $handler = Router::getHandler($path);
    $handler->run()->display();
} catch (DatabaseExp $databaseExp) {
    $errors = [];
    $errors['code'] = $databaseExp->getCode();
    $errors['file'] = $databaseExp->getFile();
    $errors['line'] = $databaseExp->getLine();
    $trace = [];
    foreach($databaseExp->getTrace() as $key => $elem) {
        $trac[] = array_slice($databaseExp->getTrace()[$key], 0,2);
        foreach ($trac as $key => $value) {
        }
        $trace[] = $value['file'] . ':' . $value['line'] . PHP_EOL;
    }
    $errors['trace'] = $trace;
    $errors['date'] = \date("Y-m-d");
    $errors['sql'] = $databaseExp->getSql();
    file_put_contents(__DIR__.'/controllerslog.txt', json_encode($errors) . PHP_EOL, FILE_APPEND);

}