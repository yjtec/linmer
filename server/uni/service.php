<?php

namespace server\uni;

use server\uni\db\redis;
use server\uni\service\heart;

/**
 * Description of service
 *
 * @author Administrator
 */
class service extends platform {

    public static $platform = 'service';

    public static function add($group, $host, $data) {
        $data['status'] = 1;
        $key = parent::add($group, $host, $data);
        dispatch::addDispatch($group, $host);
        return $key;
    }

    public static function del($group, $host) {
        $key = parent::del($group, $host);
        dispatch::addDispatch($group, $host);
        return $key;
    }

    public static function update($group, $host, $data) {
        $key = parent::update($group, $host, $data);
        dispatch::addDispatch($group, $host);
        return $key;
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
        dispatch::addDispatch($group, $host);
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
