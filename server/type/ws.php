<?php

namespace server\type;

/**
 * Description of ws
 *
 * @author Administrator
 */
class ws {

    public function open($ws, $request) {
        echo "ws,open." . PHP_EOL;
    }

    public function msg($ws, $frame) {
        echo "ws,msg." . PHP_EOL;
//        $serv->send($fd, 'Swoole: ' . $data);
    }

    public function cls($ws, $fd) {
        echo "ws,cls." . PHP_EOL;
    }

}
