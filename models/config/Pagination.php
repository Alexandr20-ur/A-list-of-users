<?php
namespace app\models\config;

use app\Action;
use app\views\View;

class Pagination
{
    private $pages;
    private $page;
    private $data;
    private $url;


    public function __construct($pages, $page, $data, $url) {
        $this->pages = $pages;
        $this->page = $page;
        $this->data = $data;
        $this->url = $url;
    }

    public function run() {
        $view = new View();
        $view->setTpl(PATH.'\views\view_paginator.php');
        $view->assign('url', $this->url);
        $view->assign('pages', $this->pages);
        $view->assign('page', $this->page);
        $view->assign('data', $this->data);
        return $view;
    }

}