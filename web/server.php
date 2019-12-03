<?php

namespace web;

use cfg\Conf;
use lib\Core\Core;
use Swoole\Http\Server as Server2;

/**
 * Description of server
 *
 * @author Administrator
 */
class server {

    public function start() {
        $ws = new Server2(Conf::ServerHost, Conf::Port['web'], SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
        $ws->on('Close', [$this, 'cls']);
        $ws->on('Request', [$this, 'req']);
        $ws->start();
    }

    /**
     * 
     * @param type $request->["header","server","request","cookie","files","get","post","tmpfiles"]
     * @param type $response
     */
    public function req($request, $response) {
        Core::$swoole_request = $request;
        Core::$swoole_response = $response;
        $response->header("Content-Type", "text/html;charset=UTF-8");
        $response->header("X-Server", "Swoole");
        $response->end(Core::start());
        Core::$swoole_request = null;
        Core::$swoole_response = null;
    }

    public function cls() {
        
    }

}
