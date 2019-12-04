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

    public $uni;
    public $ws_http_server;

    public function __construct() {
        $this->uni = new uni();
        $this->ws_http_server = new Server2(Conf::ServerHost, Conf::Port['http'], SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
        $this->ws_http_server->set(array('open_http_protocol' => true));
    }

    public function start() {
        $this->bindWs();
        $this->bindWork();
        $this->bindHttp();
        $this->bindTcp();
        $this->ws_http_server->start();
    }

    public function bindWs() {
        $wss = new ws();
        $wss->uni = $this->uni;
        $this->ws_http_server->on('Open', [$wss, 'open']);
        $this->ws_http_server->on('Message', [$wss, 'msg']);
        $this->ws_http_server->on('Close', [$wss, 'cls']);
    }

    public function bindHttp() {
        $http = new http();
        $http->uni = $this->uni;
        $this->ws_http_server->on('Request', [$http, 'req']);
    }

    public function bindTcp() {
        $server = $this->ws_http_server->addlistener(Conf::ServerHost, Conf::Port['tcp'], SWOOLE_SOCK_TCP);
        $tcp = new tcp();
        $tcp->uni = $this->uni;
        $server->on('Connect', [$tcp, 'conn']);
        $server->on('Receive', [$tcp, 'recv']);
        $server->set([]);
    }

    public function bindWork() {
        $this->ws_http_server->on('WorkerStart', [new worker(), 'start']);
    }

}
