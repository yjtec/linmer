<?php

namespace web;

class index extends base {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $svc = \lib\service\service::getInstance();
        $i = $svc->get();
        $this->display();
    }

}
