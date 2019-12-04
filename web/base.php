<?php

namespace web;

use Yjtec\LinController\Controller;

class base extends Controller {

    public $admin;

    public function __construct() {
        $this->checkLogin();
    }

    public function checkLogin() {
        session_start();
        if (!$_SESSION['admin']) {
            header('Location:/login');
            exit;
        }
        $this->admin = json_decode($_SESSION['admin'], true);
    }

}
