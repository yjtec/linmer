<?php

namespace web\admin;

class index extends base {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->display();
    }

}
