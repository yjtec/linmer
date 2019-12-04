<?php

namespace server;

/**
 * 通过网络接口获取到数据后，统一到此处进行后续处理
 *
 * @author Administrator
 */
class uni {

    public $Msg;
    public $errmsg;
    public $errnum;

    public function doMsg() {
        if (!$this->Msg || !isset($this->Msg['platform']) || !$this->Msg['platform'] || !isset($this->Msg['event']) || !$this->Msg['event']) {
            $this->errnum = -1;
            $this->errmsg = '消息体、终端类型、终端事件不存在！';
            return false;
        }
        $className = 'server\\uni\\' . $this->Msg['platform'] . '\\' . $this->Msg['event'];
        if (!class_exists($className)) {
            $this->errnum = -1;
            $this->errmsg = '不支持的事件';
            return false;
        }
        $class = new $className($this);
        $msg = $class->run();
        if (!$msg) {
            $this->errnum = $class->errnum;
            $this->errmsg = $class->errmsg;
        }
        return $msg;
    }

    public function getError() {
        return ['status' => $this->errnum, 'msg' => $this->errmsg];
    }

}
