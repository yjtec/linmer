<?php

namespace web;

use lib\Core\View;

class index extends base {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        return View::display();
    }

}
