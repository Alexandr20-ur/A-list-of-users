<?php
namespace app;

use app\controllers\AddController;
use app\controllers\AddProductController;
use app\controllers\ConfirmProductController;
use app\controllers\ConfirmDelitController;
use app\controllers\Controller;
use app\controllers\DeleteController;
use app\controllers\EditController;
use app\controllers\ErrorPageController;
use app\controllers\LogController;
use app\controllers\ListController;
use app\controllers\ProductListController;
use app\core\Database;
use app\models\config\Debag;
use app\models\config\Pagination;
use http\Message;
use mysql_xdevapi\ExecutionStatus;

class Router {
    //
    //Router отвечает за навигацию по страницам
    //
    static function getHandler(string $path): Action {
        $values  = $_GET;
        $page = $_GET['page'] ?? 1;
        $data = array_merge($_GET, $_POST);
        switch ($path) {
            case 'add':
                return new AddController($data);
            case 'edit?'.http_build_query($values):
                return new EditController($data);
            case 'delete?'.http_build_query($values):
                return new ConfirmDelitController($data['id']);
            case 'del':
                return new DeleteController($data['id']);
            case 'log':
            case 'log?' . http_build_query($values):
                return new LogController($page, $data);
            case 'list':
            case 'list?' . http_build_query($values):
                return new ListController($page, $data);
            case 'Goods_add':
            case 'Goods_add?'.http_build_query($values):
                return new AddProductController($data);
            case 'b':
            case 'b?'.http_build_query($values):
                return new ConfirmProductController($data);
            case 'product?'.http_build_query($values):
                return new ProductListController($data);
            default:
                return new ErrorPageController();
        }
    }
}