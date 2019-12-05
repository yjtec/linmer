<?php

namespace web\admin;

/**
 * Description of admin
 *
 * @author KKnV_GU
 */
class admin extends base {

    public function upPwd() {
        $this->display();
    }

    public function doUpPwd($data) {
        if ($data['npwd']) {
            $admin = new \lib\admin();
            if ($admin->updatePwd($this->admin['acc'], $data['npwd'])) {
                $this->json(1, 'success');
            }
        }
        $this->json(-1, 'error');
    }

}
