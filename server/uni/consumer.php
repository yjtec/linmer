<?php

namespace server\uni;

use server\uni\db\redis;

/**
 * Description of consumer
 *
 * @author Administrator
 */
class consumer extends platform {

    public static $platform = 'consumer';

    public static function add($group, $host, $data) {
        $data['status'] = 1;
        parent::add($group, $host, $data);
        return service::getGroup($data['service']);
    }

    public static function update($group, $host, $data) {
        parent::update($group, $host, $data);
        return service::getGroup($data['service']);
    }

    /**
     * 服务更新的时候，加入通知表
     * @param type $group
     * @param type $host
     */
    public static function addDispatch($group, $host) {
        $key = self::getKey($group, $host);
        redis::delHash($key, 'dispatch');
        $consumerKey = [];
        $consumers = self::getAll();
        foreach ($consumers as $key => $consumer) {
            $csm = json_decode($consumer, true);
            if (in_array($group, $csm["service"]) && isset($csm['dispatch_enable']) && $csm['dispatch_enable']) {
                $consumerKey[] = $key;
            }
        }
        if (!empty($consumerKey)) {
            $data = ['key' => $key, 'time' => time(), 'consumer' => $consumerKey];
            redis::addHash($key, $data, 'dispatch');
        }
    }

    /**
     * 服务更新，通知给订阅的消费者
     */
    public static function dispatch() {
        $dispatch = redis::getAllHash('dispatch');
        foreach ($dispatch as $key => $ds) {
            var_dump($ds);
        }
    }

}
