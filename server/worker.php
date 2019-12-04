<?php

namespace server;

use cfg\Conf;
use server\uni\consumer;
use server\uni\service;

/**
 * Description of worker
 *
 * @author Administrator
 */
class worker {

    public function start($serv, $worker_id) {
        echo 'worker.' . $worker_id . PHP_EOL;
        if ($worker_id == 0) {
            swoole_timer_tick(Conf::ServiceHeartBeatTime, function($timer_id) {
                service::heartBeat();
            });
        } elseif ($worker_id == 1) {
            swoole_timer_tick(Conf::ConsumerDispatchTime, function($timer_id) {
                consumer::dispatch();
            });
        }
    }

}
