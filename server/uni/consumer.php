<?php

namespace server\uni;

use server\uni\db\redis;

/**
 * Description of consumer
 *
 * @author Administrator
 */
class consumer {

    public static $platform = 'consumer';

    public static function add($group, $host, $data) {
        $key = self::getKey($group, $host);
        $data['status'] = 1;
        redis::addHash($key, $data, self::$platform);
        return service::getGroup($data['service']);
    }

    public static function update($group, $host, $data) {
        $key = self::getKey($group, $host);
        redis::updateHash($key, $data, self::$platform);
        return $key;
    }

    public static function del($group, $host) {
        $key = self::getKey($group, $host);
        redis::delHash($key, self::$platform);
        return 1;
    }

    public static function get($group, $host) {
        $key = self::getKey($group, $host);
        $data = redis::getHash($key, self::$platform);
        return empty($data) ? [] : json_decode($data, true);
    }

    public static function getAll() {
        return redis::getAllHash(self::$platform);
    }

    public static function getKey($group, $host) {
        return md5($group . $host);
    }

    public static function addDispatch($key) {
        redis::delHash($key, 'dispatch');
        redis::addHash($key, ['time' => time()], 'dispatch');
    }

    /**
     * 服务更新，通知给订阅的消费者
     */
    public static function dispatch() {
        $ds = redis::getAllHash('dispatch');
//        $consumers = self::getAll();
//        foreach ($services as $key => $service) {
//            self::startHeartBeat(json_decode($service, true));
//        }
    }

}
