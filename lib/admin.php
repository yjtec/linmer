<?php

namespace lib;

use lib\file\adminMd;

/**
 * Description of admin
 *
 * @author KKnV_GU
 */
class admin {

    public $adm;

    public function __construct() {
        $this->adm = new adminMd();
    }

    public function checkAdmin($acc, $pwd) {
        $admin = $this->adm->getByAcc($acc);
        if (!$admin) {
            return false;
        }
        if (!$this->adm->cPwd($admin['acc'], $pwd, $admin['salt']) == $admin['pwd']) {
            return false;
        }
        return $admin;
    }

    public function add($acc, $pwd) {
        return $this->adm->add($acc, $pwd);
    }

}
