<?php

namespace server\uni\db;

use cfg\Conf;

/**
 * Description of redis
 *
 * @author Administrator
 */
class redis {

    public static $redis;

    public static function addHash($key, $data, $hashName = null) {
        self::conn();
        self::$redis->hset(Conf::DB_CNF['prefix'] . $hashName, $key, json_encode($data));
        return $key;
    }

    public static function delHash($key, $hashName = null) {
        self::conn();
        return self::$redis->hdel(Conf::DB_CNF['prefix'] . $hashName, $key);
    }

    public static function updateHash($key, $data, $hashName = null) {
        return self::addHash($key, $data, $hashName);
    }

    public static function getHash($key, $hashName = null) {
        self::conn();
        return self::$redis->hget(Conf::DB_CNF['prefix'] . $hashName, $key);
    }

    public static function getAllHash($hashName = null) {
        self::conn();
        return self::$redis->hgetall(Conf::DB_CNF['prefix'] . $hashName);
    }

    public static function conn() {
        if (!self::$redis) {
            self::$redis = new \Redis();
            self::$redis->connect('127.0.0.1', 6379);
            self::$redis->select(10);
        }
    }

}
