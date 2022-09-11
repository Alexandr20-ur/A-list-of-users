<?php
namespace app\controllers;
use app\Action;
use app\views\View;
use app\models\{config\Debag, config\Pagination, config\ReadFile,};

class LogController implements Action {

    const RECORDS = 15;

    private $page;
    private $data;

    public function __construct($page, $data) {
        $this->page = $page;
        $this->data = $data;
    }

    public function run() {
        $view = new View();
        $view->setTpl(PATH.'\views\logi.php');
        $view->content = $this->logs();
        return $view;
    }

    private function logs() {
        $view = new View();

        $read = new ReadFile(PATH.'\controllerslog.txt', $this->page ?? 1, self::RECORDS, $this->data);
        $iterator = $read->readTheFile();

        $count = $read->getCount();
        $pages = ceil($count / self::RECORDS);

        $view->setTpl(PATH.'\views\view_logs.php');
        $view->assign('data', $this->data);
        $view->assign('read',$iterator);
        $view->assign('pages', $pages);
        $view->assign('ipage', $this->page);
        $view->assign('number', $count);
        echo $this->convert(memory_get_usage());
        $url = 'log?';
        $view->navigation = $this->pageNavigation($pages, $this->page, $this->data, $url);
        return $view;
    }

    private function pageNavigation($pages, $ipage, $data, $url) {
        return (new Pagination($pages, $ipage, $data, $url))->run();
    }

    private function convert($size) {
        $unit = array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

}