<?php
namespace app\views;

class View {
    private $tpl;
    private $data = [];
    private $widgets = [];
    /**
     * @var EmptyView|View|mixed
     */

    function assign($k, $v) {
        $this->data[$k] = $v;
    }

    function get($k, $default = null) {
        return isset($this->data[$k]) ? $this->data[$k] : $default;
    }

    function setTpl($tpl) {
        if (file_exists($tpl)) $this->tpl = $tpl;
    }

    function display() {
        if ($this->tpl) include $this->tpl;
    }

    function __set($name, $value) {
        $this->widgets[$name] = $value;
    }

    function __get($name) {
        return isset($this->widgets[$name]) ? $this->widgets[$name] : new EmptyView();
    }
}