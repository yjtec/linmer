<?php

namespace server;

use cfg\Conf;
use server\uni\dispatch;
use server\uni\service;

/**
 * Description of worker
 *
 * @author Administrator
 */
class worker {

    public function start($serv, $worker_id) {
        slog::showLog('进程开始：' . $worker_id);
        if ($worker_id == 0) {
            slog::showLog('心跳进程：' . $worker_id);
            swoole_timer_tick(Conf::ServiceHeartBeatTime, function($timer_id) {
                service::heartBeat();
            });
        } elseif ($worker_id == 1) {
            slog::showLog('消费通知进程：' . $worker_id);
            swoole_timer_tick(Conf::ConsumerDispatchTime, function($timer_id) {
                dispatch::dispatch();
            });
        } elseif ($worker_id == 2) {
            slog::showLog('配置通知进程：' . $worker_id);
//            swoole_timer_tick(Conf::ConsumerDispatchTime, function($timer_id) {
//                dispatch::dispatch();
//            });
        }
    }

}
