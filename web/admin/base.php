<?php

namespace web\admin;

use Yjtec\LinController\Controller;

class base extends Controller {

    public $admin;

    public function __construct() {
        $this->checkLogin();
        $this->take('adminInfo', $this->admin);
    }

    public function checkLogin() {
        session_start();
        $this->admin = isset($_SESSION['admin']) ? json_decode($_SESSION['admin'], true) : [];
        if (!isset($this->admin['acc']) || !$this->admin['acc']) {
            header('Location:/admin/login');
            exit;
        }
    }

    public function json($status, $msg, $data = []) {
        $this->ajaxReturn(['status' => $status, 'msg' => $msg, 'data' => $data]);
    }

}
