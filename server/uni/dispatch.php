<?php

namespace server\uni;

use server\slog;
use server\uni\consumer\dispatch as dispatch2;
use server\uni\db\redis;

/**
 * Description of dispatch
 *
 * @author Administrator
 */
class dispatch extends platform {

    public static $platform = 'dispatch';

    /**
     * 服务更新的时候，加入通知表
     * @param type $group
     * @param type $host
     */
    public static function addDispatch($group, $host) {
        $key = self::getKey($group, $host);
        redis::delHash($key, 'dispatch');
        $consumerKey = [];
        $consumers = consumer::getAll();
        foreach ($consumers as $key => $consumer) {
            $csm = json_decode($consumer, true);
            if (in_array($group, $csm["service"]) && isset($csm['dispatch_enable']) && $csm['dispatch_enable'] && isset($csm['dispatch_url']) && $csm['dispatch_url']) {
                $consumerKey[] = ['key' => $key, 'status' => 0];
            }
        }
        if (!empty($consumerKey)) {
            $data = ['key' => $key, 'time' => time(), 'consumer' => $consumerKey];
            $key = parent::add($group, $host, $data);
        }
    }

    /**
     * 服务更新，通知给订阅的消费者
     */
    public static function dispatch() {
        $dispatchs = self::getAll();
        if ($dispatchs) {
            slog::showLog('发现需要推送：' . json_encode($dispatchs));
            foreach ($dispatchs as $key => $dispatch) {
                $dis = json_decode($dispatch, true);
                $service = service::getByKey($key);
                foreach ($dis['consumer'] as &$consumer) {
                    $csm = consumer::getByKey($consumer['key']);
                    $allDispatchSuccess = true;
                    if (!isset($consumer['status']) || ($consumer['status'] < 1 && $consumer['status'] > -100)) {
                        if (dispatch2::startDispatch($csm, $service)) {
                            $consumer['status'] = 1;
                            $consumer['utime'] = time();
                        } else {
                            $allDispatchSuccess = false;
                            $consumer['status'] = $consumer['status'] - 1;
                            $consumer['utime'] = time();
                        }
                    }
                }
                if ($allDispatchSuccess) {
                    redis::addHash($key, $dis, 'dispatch_end');
                    self::delByKey($key);
                } else {
                    self::updateByKey($key, $dis);
                }
            }
        }
    }

}
