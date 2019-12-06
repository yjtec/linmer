<?php

namespace server\uni;

use server\uni\db\redis;

/**
 * Description of platform
 *
 * @author Administrator
 */
class platform {

    public static $platform;

    public static function add($group, $host, $data) {
        $key = self::getKey($group, $host);
        redis::addHash($key, $data, static::$platform);
        return $key;
    }

    public static function del($group, $host) {
        $key = self::getKey($group, $host);
        return self::delByKey($key);
    }

    public static function delByKey($key) {
        redis::delHash($key, static::$platform);
        return $key;
    }

    public static function update($group, $host, $data) {
        $key = self::getKey($group, $host);
        return self::updateByKey($key, $data);
    }

    public static function updateByKey($key, $data) {
        redis::updateHash($key, $data, static::$platform);
        return $key;
    }

    public static function get($group, $host) {
        $key = self::getKey($group, $host);
        return self::getByKey($key);
    }

    public static function getByKey($key) {
        $data = redis::getHash($key, static::$platform);
        return empty($data) ? [] : json_decode($data, true);
    }

    /**
     * 根据分组标识获取所有
     * @param type $group
     * @return type
     */
    public static function getGroup($group) {
        $groupSvc = [];
        $services = static::getAll();
        foreach ($services as $key => $service) {
            $svc = json_decode($service, true);
            if ((is_array($group) && in_array($svc['group'], $group)) || (is_string($group) && $svc['group'] == $group)) {
                $groupSvc[] = $svc;
            }
        }
        return $groupSvc;
    }

    public static function getAll() {
        return redis::getAllHash(static::$platform);
    }

    public static function getKey($group, $host) {
        return md5($group . $host);
    }

}
