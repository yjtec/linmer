<?php

namespace lib\Core;

use Exception;
use lib\Core\Router;
use ReflectionMethod;

class Core {

    public static $swoole_request = null;
    public static $swoole_response = null;

    /**
     * 应用程序初始化
     * @access public
     * @return void
     */
    public static function start() {
        $routes = Router::getCLS(); //获取路由信息
        if (empty($routes)) {
            throw new Exception('路由不存在');
        }
        $class = $routes[0];
        $function = $routes[1];
        if (self::$swoole_request) {
            $routes[2]['request'] = self::$swoole_request;
        }
        if (self::$swoole_request) {
            $routes[2]['responst'] = self::$swoole_response;
        }
        return self::doClass($class, $function, $routes[2]);
    }

    public static function doClass($class, $function, $params) {
        if (!class_exists($class)) {
            throw new Exception('不存在的类');
        }
        if ($function && (new ReflectionMethod($class, $function))->isStatic()) {
            return call_user_func_array(array($class, $function), $params);
        }
        $controller = new $class();
        if ($function && method_exists($controller, $function)) {
            return call_user_func_array(array($controller, $function), $params);
        }
        return true;
    }

}
