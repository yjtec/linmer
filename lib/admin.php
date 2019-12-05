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
        if ($admin && $this->adm->cPwd($admin['acc'], $pwd, $admin['salt']) == $admin['pwd']) {
            return $admin;
        }
        return false;
    }

    public function add($acc, $pwd) {
        return $this->adm->add($acc, $pwd);
    }

    public function updatePwd($acc, $pwd) {
        return $this->adm->updatePwd($acc, $pwd);
    }

}
