<?php

namespace server\type;

/**
 * Description of ws
 *
 * @author Administrator
 */
class ws extends base {

    public $uni;

    public function open($ws, $request) {
        slog::showLog('收到ws连接：open');
    }

    public function msg($ws, $frame) {
        slog::showLog('收到ws数据：' . $frame->data);
        echo "ws,msg." . $frame->data . PHP_EOL;
        $this->sendMsg($ws, $frame->fd, "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n");
    }

    public function cls($ws, $fd) {
        slog::showLog('关闭ws连接');
    }

    public function sendMsg($context, $user, $msg) {
        $context->push($user, $msg);
    }

}
