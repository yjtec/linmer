<?php

namespace server\type;

/**
 * Description of tcp
 *
 * @author Administrator
 */
class tcp {

    public function conn($serv, $fd) {
        echo "tcp,conn." . PHP_EOL;
    }

    public function recv($serv, $fd, $threadId, $data) {
        echo "tcp,recv." . PHP_EOL;
    }

}
