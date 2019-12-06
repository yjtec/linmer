<?php

namespace server\uni\consumer;

/**
 * 通知
 *
 * @author Administrator
 */
class dispatch {

    public static function startDispatch($consumer, $service) {
        $function = isset($consumer['dispatch_type']) && $consumer['dispatch_type'] ? $consumer['dispatch_type'] : "default";
        switch ($function) {
            case 'http':
                return self::http($consumer, $service);
            case 'ws':
                return self::ws($consumer, $service);
            case 'tcp':
                return self::tcp($consumer, $service);
            default :
                return self::default($consumer, $service);
        }
    }

    public static function http($consumer, $service) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $consumer['dispatch_url']);
        // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($service));
        $t1 = microtime(true);
        $rs = curl_exec($ch);
        $t = microtime(true) - $t1;
        $curlInfo = curl_getinfo($ch);
        curl_close($ch);
        return $rs == 'success' ? $curlInfo['total_time'] : false;
    }

    public static function ws($consumer, $service) {
        
    }

    public static function tcp($consumer, $service) {
        
    }

    public static function default($consumer, $service) {
        return self::http($consumer, $service);
    }

    public static function checkResult($consumer, $service, $data) {
        
    }

}
