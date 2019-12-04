<?php

namespace server\uni\service;

/**
 * Description of heart
 *
 * @author Administrator
 */
class heart {

    public static function startHeart($svc) {
        $function = isset($svc['heart_type']) && $svc['heart_type'] ? $svc['heart_type'] : "default";
        switch ($function) {
            case 'http':
                return self::http($svc);
            case 'ws':
                return self::ws($svc);
            case 'tcp':
                return self::tcp($svc);
            default :
                return self::default($svc);
        }
    }

    public static function http($svc) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $svc['heart_url']);
        // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $t1 = microtime(true);
        curl_exec($ch);
        $t = microtime(true) - $t1;
        $curlInfo = curl_getinfo($ch);
        curl_close($ch);
        return $curlInfo['http_code'] == '200' ? $curlInfo['total_time'] : false;
    }

    public static function ws($svc) {
        
    }

    public static function tcp($svc) {
        
    }

    public static function default($svc) {
        return self::http($svc);
    }

    public static function checkResult($svc, $data) {
        
    }

}
