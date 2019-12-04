<?php

namespace server\uni\consumer;

use server\uni\consumer;
use server\uni\event;

/**
 * Description of register
 *
 * @author Administrator
 */
class subscribe extends event {

    private $uni;

    public function __construct($uni) {
        $this->uni = $uni;
    }

    public function run() {
        $msg = $this->checkMsg($this->uni->Msg);
        if (!$msg) {
            return false;
        }
        $service = consumer::add($msg['group'], $msg['host'], $msg);
        return ['status' => 1, 'msg' => 'success', 'data' => $service];
    }

    public function checkMsg($msg) {
        if (!isset($msg['group']) || !isset($msg['host']) || !isset($msg['service'])) {
            $this->errnum = 1001;
            $this->errmsg = '分组标识、消费地址、订阅服务列表不合法';
            return false;
        }
        $msg['service'] = explode(',', $msg['service']);
        unset($msg['platform']);
        unset($msg['event']);
        return $msg;
    }

}
