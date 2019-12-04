<?php

namespace server\uni\service;

use server\uni\event;
use server\uni\service;

/**
 * Description of register
 *
 * @author Administrator
 */
class register extends event {

    private $uni;

    public function __construct($uni) {
        $this->uni = $uni;
    }

    public function run() {
        $msg = $this->checkMsg($this->uni->Msg);
        if (!$msg) {
            return false;
        }
        $id = service::add($msg['group'], $msg['host'], $msg);
        return ['status' => 1, 'msg' => 'success', 'data' => $id];
    }

    public function checkMsg($msg) {
        if (!isset($msg['group']) || !isset($msg['host'])) {
            $this->errnum = 1001;
            $this->errmsg = '服务标识、服务地址不合法';
            return false;
        }
        unset($msg['platform']);
        unset($msg['event']);
        return $msg;
    }

}
