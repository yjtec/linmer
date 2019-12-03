<?php

namespace web;

class index extends base {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->display();
    }

}
