<?php

namespace server;

use cfg\Conf;
use server\type\http;
use server\type\tcp;
use server\type\ws;
use Swoole\WebSocket\Server as Server2;

/**
 * Description of server
 *
 * @author Administrator
 */
class server {

    public function start() {
        $ws = new Server2(Conf::ServerHost, Conf::Port['http'], SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
        $ws->set(array('open_http_protocol' => true));
        $wss = new ws();
        $ws->on('Open', [$wss, 'open']);
        $ws->on('Message', [$wss, 'msg']);
        $ws->on('Close', [$wss, 'cls']);
        $ws->on('WorkerStart', [new worker(), 'start']);
        $ws->on('Request', [new http(), 'req']);
        $server = $ws->addlistener(Conf::ServerHost, Conf::Port['tcp'], SWOOLE_SOCK_TCP);
        $tcp = new tcp();
        $server->on('Connect', [$tcp, 'conn']);
        $server->on('Receive', [$tcp, 'recv']);
        $server->set([]);
        $ws->start();
    }

}
