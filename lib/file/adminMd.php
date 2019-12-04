<?php

namespace lib\file;

/**
 * Description of admin
 *
 * @author KKnV_GU
 */
class adminMd extends file {

    public $adminFilePath = './cfg/data/admin';

    public function getByAcc($acc) {
        $admins = $this->getAll();
        foreach ($admins as $admin) {
            if ($admin['acc'] == $acc) {
                return $admin;
            }
        }
        return [];
    }

    public function add($acc, $pwd) {
        $admins = $this->getAll();
        foreach ($admins as $admin) {
            if ($admin['acc'] == $acc) {
                return false;
            }
        }
        $admins[] = $this->cAdm($acc, $pwd);
        return $this->write($this->adminFilePath, $admins);
    }

    public function updatePwd($acc, $pwd) {
        $admins = $this->getAll();
        foreach ($admins as &$admin) {
            if ($admin['acc'] == $acc) {
                $admin['salt'] = $this->salt();
                $admin['pwd'] = $this->cPwd($acc, $pwd, $admin['salt']);
                return $this->write($this->adminFilePath, $admins);
            }
        }
        return false;
    }

    public function initAdmin() {
        $admin = $this->cAdm('admin', 'admin');
        $this->write($this->adminFilePath, [$admin]);
        return $admin;
    }

    public function getAll() {
        $content = $this->read($this->adminFilePath);
        if (empty($content)) {
            return $this->initAdmin();
        }
        return $content;
    }

    public function cAdm($acc, $pwd) {
        $admin['acc'] = $acc;
        $admin['salt'] = $this->salt();
        $admin['pwd'] = $this->cPwd($admin['acc'], $pwd, $admin['salt']);
        return $admin;
    }

    public function cPwd($acc, $pwd, $salt) {
        return md5($acc . $pwd . $salt);
    }

    public function salt($length = 8) {
        $strs = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        return substr(str_shuffle($strs), mt_rand(0, strlen($strs) - $length - 1), $length);
    }

}
