<?php

namespace server\type;

use server\slog;

/**
 * Description of tcp
 *
 * @author Administrator
 */
class tcp extends base {

    public $uni;

    public function conn($serv, $fd) {
        slog::showLog('收到tcp连接');
    }

    public function recv($serv, $fd, $threadId, $data) {
        slog::showLog('tcp收到数据：' . $data);
        $this->uni->Msg = json_decode($data, true);
        $msg = $this->uni->doMsg();
        if (!$msg) {
            $msg = ['status' => $this->uni->errnum, 'msg' => $this->uni->errmsg];
        }
        $this->sendMsg($serv, $fd, $msg);
    }

    public function sendMsg($context, $user, $msg) {
        $context->send($user, $msg);
    }

}
