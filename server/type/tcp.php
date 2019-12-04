<?php

namespace server\type;

/**
 * Description of tcp
 *
 * @author Administrator
 */
class tcp extends base {

    public $uni;

    public function conn($serv, $fd) {
        echo "tcp,conn." . PHP_EOL;
    }

    public function recv($serv, $fd, $threadId, $data) {
        echo "tcp,recv." . $data . PHP_EOL;
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
