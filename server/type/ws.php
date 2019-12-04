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
        echo "ws,open." . PHP_EOL;
    }

    public function msg($ws, $frame) {
        echo "ws,msg." . $frame->data . PHP_EOL;
        $this->sendMsg($ws, $frame->fd, "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n");
    }

    public function cls($ws, $fd) {
        echo "ws,cls." . PHP_EOL;
    }

    public function sendMsg($context, $user, $msg) {
        $context->push($user, $msg);
    }

}
