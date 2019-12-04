<?php

namespace server\uni;

use server\uni\db\redis;
use server\uni\service\heart;

/**
 * Description of service
 *
 * @author Administrator
 */
class service {

    public static $platform = 'service';

    public static function add($group, $host, $data) {
        $key = self::getKey($group, $host);
        $data['status'] = 1;
        redis::addHash($key, $data, self::$platform);
        consumer::addDispatch($key);
        return $key;
    }

    public static function update($group, $host, $data) {
        $key = self::getKey($group, $host);
        redis::updateHash($key, $data, self::$platform);
        consumer::addDispatch($key);
        return $key;
    }

    public static function del($group, $host) {
        $key = self::getKey($group, $host);
        redis::delHash($key, self::$platform);
        consumer::addDispatch($key);
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

    public static function getGroup($group) {
        $groupSvc = [];
        $services = self::getAll();
        foreach ($services as $key => $service) {
            $svc = json_decode($service, true);
            if ((is_array($group) && in_array($svc['group'], $group)) || (is_string($group) && $svc['group'] == $group)) {
                $groupSvc[] = $svc;
            }
        }
        return $groupSvc;
    }

    public static function getKey($group, $host) {
        return md5($group . $host);
    }

    private static function updateLiveTime($group, $host, $time) {
        $svc = self::get($group, $host);
        $key = self::getKey($group, $host);
        $svc['live_time'] = $time;
        $svc['utime'] = time();
        redis::updateHash($key, $svc, self::$platform);
        return 1;
    }

    private static function heartBeatFail($group, $host, $status) {
        $svc = self::get($group, $host);
        $key = self::getKey($group, $host);
        $svc['utime'] = time();
        $svc['live_time'] = -1;
        $svc['status'] = $status;
        redis::updateHash($key, $svc, self::$platform);
        consumer::addDispatch($key);
        return 1;
    }

    /**
     * 服务的心跳事件
     */
    public static function heartBeat() {
        $services = self::getAll();
        foreach ($services as $key => $service) {
            $svc = json_decode($service, true);
            if ($svc['heart_enable']) {
                $responseTime = heart::startHeart($svc);
                if ($responseTime) {
                    self::updateLiveTime($svc['group'], $svc['host'], $responseTime);
                } else {
                    $status = $svc['status'] > 0 ? -1 : $svc['status'] - 1;
                    self::heartBeatFail($svc['group'], $svc['host'], $status);
                }
            }
        }
    }

}
