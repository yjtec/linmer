<?php

namespace web\admin;

use Yjtec\LinController\Controller;

/**
 * Description of login
 *
 * @author KKnV_GU
 */
class login extends Controller {

    public function index() {
//        var_dump($_SESSION);
        $this->display();
    }

    public function doLogin($data) {
        $admSvc = new \lib\admin();
        $admin = $admSvc->checkAdmin($data['acc'], $data['pwd']);
        if (!$admin) {
            header('Location:/admin/login?err=fail');
            exit();
        }
        session_start();
        $_SESSION['admin'] = json_encode($admin);
        header('Location:/admin/index');
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location:/admin/index');
    }

}
